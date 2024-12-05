<?php
namespace Superadminx\News;

use think\facade\Db;

class Install
{
    const WEBMAN_PLUGIN = true;

    /**
     * 要拷贝的数据
     * @var array
     */
    protected static $pathRelation = [
        [
            'source' => '/plugin', //源目录
            'dest'   => '/plugin', //拷贝目标目录
            'type'   => 'folder', //类型，是拷贝源目录下的文件夹还是文件，folder》文件夹，file》文件
        ],
        [
            'source' => '/react/api',
            'dest'   => '/public/admin_react/src/api',
            'type'   => 'file',
        ],
        [
            'source' => '/react/components',
            'dest'   => '/public/admin_react/src/components',
            'type'   => 'file',
        ],
        [
            'source' => '/react/pages',
            'dest'   => '/public/admin_react/src/pages',
            'type'   => 'folder',
        ],
    ];

    // db的配置，用来标识是否已配置
    public static $dbConfig = [];

    /**
     * Install
     * @return void
     */
    public static function install()
    {
        echo "开始安装\n";
        try {
            // 初始化db
            self::dbInit();

            // 开始检测安装条件
            if (self::installDetection()) {

                foreach (self::$pathRelation as $item) {
                    if (!is_dir(__DIR__ . $item['source'])) {
                        continue;
                    }

                    // 拷贝文件夹
                    if ($item['type'] == 'folder') {
                        $folderNames = self::getFolderNames(__DIR__ . $item['source']);
                        foreach ($folderNames as $v) {
                            copy_dir(__DIR__ . "{$item['source']}/{$v}", base_path() . "{$item['dest']}/{$v}");
                        }
                    }

                    // 拷贝文件
                    if ($item['type'] == 'file') {
                        $fileNames = self::getAllFiles(__DIR__ . $item['source']);
                        foreach ($fileNames as $v) {
                            copy(__DIR__ . "{$item['source']}/{$v}", base_path() . "{$item['dest']}/{$v}");
                        }
                    }
                }

                // 是否存在adminMenu.sql
                $sqlPath = __DIR__ . '/adminMenu.sql';
                if (file_exists($sqlPath) && is_file($sqlPath)) {
                    self::installSql($sqlPath);
                }

                // 是否存在createTable.sql
                $sqlPath = __DIR__ . '/createTable.sql';
                if (file_exists($sqlPath) && is_file($sqlPath)) {
                    self::installSql($sqlPath);
                }

                echo "安装成功\n";
            }
        } catch (\Exception $e) {
            echo "{$e->getMessage()}\n";
            echo "安装失败：请删除依赖》解决问题》重新安装\n";
        }

    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall()
    {
        // 初始化db
        self::dbInit();

        foreach (self::$pathRelation as $item) {
            if (!is_dir(__DIR__ . $item['source'])) {
                continue;
            }

            // 删除文件夹
            if ($item['type'] == 'folder') {
                $folderNames = self::getFolderNames(__DIR__ . $item['source']);
                foreach ($folderNames as $v) {
                    remove_dir(base_path() . "{$item['dest']}/{$v}");
                }
            }

            // 删除文件
            if ($item['type'] == 'file') {
                $fileNames = self::getAllFiles(__DIR__ . $item['source']);
                foreach ($fileNames as $v) {
                    unlink(base_path() . "{$item['dest']}/{$v}");
                }
            }
        }

        // 检测是否有adminMenu.sql，需要删除表中的权限节点
        $sqlPath = __DIR__ . '/adminMenu.sql';
        if (file_exists($sqlPath) && is_file($sqlPath)) {
            // 提炼出安装的节点name
            $adminMenuNames = self::getMenuNames($sqlPath);
            if ($adminMenuNames) {
                echo self::$dbConfig['DB_PREFIX'] . 'admin_menu' . "\n";
                foreach ($adminMenuNames as $v) {
                    echo "{$v}\n";
                }
                Db::table(self::$dbConfig['DB_PREFIX'] . 'admin_menu')->where('name', 'in', $adminMenuNames)->delete();
            }
        }

        // 检测是否有createTable.sql，需要删除表
        $sqlPath = __DIR__ . '/createTable.sql';
        if (file_exists($sqlPath) && is_file($sqlPath)) {
            // 提炼出安装的表名
            $tables = self::getTableNamesFromSqlFile($sqlPath);
            foreach ($tables as $v) {
                Db::query("DROP TABLE IF EXISTS {$v};");
            }
        }
    }



    /**
     * 安装前检测是否能安装
     * @return void
     */
    private static function installDetection()
    {
        // 是否能成功安装
        $result = true;

        foreach (self::$pathRelation as $item) {
            if (!is_dir(__DIR__ . $item['source'])) {
                continue;
            }
            
            // 检测拷贝文件夹
            if ($item['type'] == 'folder') {
                // 获取源文件夹下所有的文件夹名
                $folderNames = self::getFolderNames(__DIR__ . $item['source']);
                foreach ($folderNames as $v) {
                    // 检测目标文件夹是否已存在
                    $tmp = base_path() . "{$item['dest']}/{$v}";
                    if (is_dir($tmp)) {
                        echo "安装失败：目录已存在{$tmp}\n";
                        $result = false;
                    }
                }
            }

            //检测拷贝文件
            if ($item['type'] == 'file') {
                // 获取源文件夹下所有的文件
                $fileNames = self::getAllFiles(__DIR__ . $item['source']);
                foreach ($fileNames as $v) {
                    $tmp = base_path() . "{$item['dest']}/{$v}";
                    if (file_exists($tmp) && is_file($tmp)) {
                        echo "安装失败：文件已存在{$tmp}\n";
                        $result = false;
                    }
                }
            }
        }

        // 提炼sql需要安装的表
        $sqlPath = __DIR__ . '/createTable.sql';
        if (file_exists($sqlPath) && is_file($sqlPath)) {
            $tables = self::getTableNamesFromSqlFile($sqlPath);
            foreach ($tables as $item) {
                $tmp = Db::query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . self::$dbConfig['DB_NAME'] . "' AND TABLE_NAME = '{$item}'");
                if (isset($tmp[0]['TABLE_NAME']) && $tmp[0]['TABLE_NAME']) {
                    echo "安装失败：数据表已存在{$item}\n";
                    $result = false;
                }
            }
        }

        return $result;
    }

    /**
     * 获取目录下的所有文件夹名
     * @param string $dir 目录路劲
     * @return string[]
     */
    private static function getFolderNames($dir) : array
    {
        $folderNames = [];
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && is_dir($dir . DIRECTORY_SEPARATOR . $entry)) {
                    $folderNames[] = $entry;
                }
            }
            closedir($handle);
        }
        return $folderNames;
    }

    /**
     * 获取文件夹下所有文件名
     * @param string $dir
     * @return string[]
     */
    private static function getAllFiles(string $dir) : array
    {
        $files = [];
        // 获取目录中的所有项（文件和文件夹）
        $items = scandir($dir);
        foreach ($items as $item) {
            // 忽略 "." 和 ".." 这两个特殊目录
            if ($item != "." && $item != "..") {
                // 构建完整的路径
                $fullPath = $dir . DIRECTORY_SEPARATOR . $item;

                // 检查是否是一个文件
                if (is_file($fullPath)) {
                    $files[] = $item;
                }
            }
        }

        return $files;
    }

    /**
     * 提炼adminMenu.sql中的插入权限节点的所有的name，卸载的时候用来删除
     * @param string $sqlPath
     * @return string[]
     */
    private static function getMenuNames(string $sqlPath) : array
    {
        $names = [];

        $sqlContent = file_get_contents($sqlPath);
        // 尝试分割 SQL 语句（注意：这只是一个简单的示例，可能不适用于所有情况）
        $sqlStatements = explode(';', $sqlContent);
        foreach ($sqlStatements as $sql) {
            // 去除语句前后的空白字符
            $sql = trim($sql);
            // 跳过空语句
            if (empty($sql)) {
                continue;
            }

            // 查找 VALUES 关键字及其后面的内容
            $valuesPart = substr($sql, strpos($sql, 'VALUES ') + strlen('VALUES '));

            // 去掉前后的括号
            $trimmedValuesPart = trim($valuesPart, '()');

            // 将值列表按逗号分隔为数组
            $valueArray = array_map('trim', explode(',', $trimmedValuesPart));

            // 提取 INSERT INTO 部分的字段名
            $fieldsPattern = '/INSERT INTO[^(]+\(([^)]+)\)/';
            preg_match($fieldsPattern, $sql, $matches);

            $fieldArray = [];
            if (isset($matches[1])) {
                // 使用逗号分隔字段名，并去除可能的空格和反引号
                $fieldArray = array_map(function ($field)
                {
                    return trim($field, '` ');
                }, explode(',', $matches[1]));
            }


            foreach ($fieldArray as $ks => $vs) {
                if ($vs == 'name') {
                    if (isset($valueArray[$ks]) && $valueArray[$ks]) {
                        $names[] = $valueArray[$ks];
                    }
                    break;
                }
            }
        }
        return $names;
    }

    /**
     * 执行sql文件
     * @param mixed $sqlPath
     * @return void
     */
    private static function installSql($sqlPath)
    {
        $sqlContent = file_get_contents($sqlPath);
        // 尝试分割 SQL 语句（注意：这只是一个简单的示例，可能不适用于所有情况）
        $sqlStatements = explode(';', $sqlContent);
        foreach ($sqlStatements as $sql) {
            // 去除语句前后的空白字符
            $sql = trim($sql);
            // 跳过空语句
            if (empty($sql)) {
                continue;
            }
            Db::query($sql);
        }
    }

    /**
     * 从sql文件中提炼出安装的表名
     * @param mixed $sqlPath
     * @return array
     */
    private static function getTableNamesFromSqlFile($sqlPath) : array
    {
        // 初始化表名数组
        $tableNames = [];

        // 读取SQL文件内容
        $sqlContent = file_get_contents($sqlPath);

        // 检查文件是否成功读取
        if ($sqlContent === false) {
            return $tableNames;
        }

        // 使用正则表达式匹配CREATE TABLE语句中的表名
        preg_match_all('/CREATE TABLE `([^`]+)`/i', $sqlContent, $matches);

        // 如果匹配成功，则$matches[1]包含了所有匹配到的表名
        if (! empty($matches[1])) {
            $tableNames = $matches[1];
        }

        // 返回表名数组
        return $tableNames;
    }

    /**
     * 初始化db配置
     * @return void
     */
    private static function dbInit()
    {
        if (! self::$dbConfig) {
            self::$dbConfig = self::getEnvs(base_path() . '/.env');
            Db::setConfig([
                // 默认数据连接标识
                'default'     => 'mysql',
                // 数据库连接信息
                'connections' => [
                    'mysql' => [
                        // 数据库类型
                        'type'            => 'mysql',
                        // 服务器地址
                        'hostname'        => self::$dbConfig['DB_HOST'],
                        // 数据库名
                        'database'        => self::$dbConfig['DB_NAME'],
                        // 数据库用户名
                        'username'        => self::$dbConfig['DB_USER'],
                        // 数据库密码
                        'password'        => self::$dbConfig['DB_PASSWORD'],
                        // 数据库连接端口
                        'hostport'        => 3306,
                        // 数据库连接参数
                        'params'          => [
                            // 连接超时3秒
                            \PDO::ATTR_TIMEOUT => 3,
                        ],
                        // 数据库编码默认采用utf8
                        'charset'         => self::$dbConfig['DB_CHARSET'],
                        // 数据库表前缀
                        'prefix'          => self::$dbConfig['DB_PREFIX'],
                        // 断线重连
                        'break_reconnect' => true,
                        // 关闭SQL监听日志
                        'trigger_sql'     => false,
                        // 自定义分页类
                        'bootstrap'       => '',
                        // 是否严格检查字段是否存在
                        'fields_strict'   => false,
                        // 开启字段缓存
                        'fields_cache'    => true,
                    ],
                ],
            ]);
        }
    }

    /**
     * 获取env文件的配置
     * @param string $envPath
     * @return string[]
     */
    private static function getEnvs(string $envPath) : array
    {
        // 读取文件内容到数组中，每行作为数组的一个元素
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        // 初始化一个空数组来存储配置信息
        $config = [];
        // 遍历每一行
        foreach ($lines as $line) {
            // 使用trim去除行首和行尾的空白字符
            $trimmedLine = trim($line);

            // 检查是否是注释行（以#开头）
            if (strpos($trimmedLine, '#') === 0) {
                continue; // 如果是注释行，则跳过
            }

            // 使用=分割键值对
            if (strpos($trimmedLine, '=') !== false) {
                list($key, $value) = explode('=', $trimmedLine, 2);

                // 去除键和值两端的空白字符
                $key   = trim($key);
                $value = trim($value);

                // 将解析后的键值对存入配置数组
                $config[$key] = $value;
            }
        }
        return $config;
    }
}