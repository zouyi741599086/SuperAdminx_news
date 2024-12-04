<?php
namespace Superadminx\News;

class Install
{
    const WEBMAN_PLUGIN = true;

    // 指定插件自己的数据库
    protected static $connection = 'thinkorm.mysql';

    // 要安装的表，同时也是卸载要扇窗户的表
    public static $installTable = ['sa_news', 'sa_news_class'];

    /**
     * Install
     * @return void
     */
    public static function install()
    {
        echo "开始安装\n";
        try {
            if (self::installDetection()) {
                // 拷贝插件
                $pluginFolderNames = self::getFolderNames(__DIR__ . "/plugin");
                foreach ($pluginFolderNames as $v) {
                    copy_dir(__DIR__ . "/plugin/{$v}", base_path() . "/plugin/{$v}");
                }

                // 拷贝api文件
                $apiPath = __DIR__ . '/react/api/';
                if (is_dir($apiPath)) {
                    // 检测是否已存在此api文件
                    $apiFiles = self::getAllFiles($apiPath);
                    foreach ($apiFiles as $v) {
                        copy($apiPath . $v, base_path() . "/public/admin_react/src/api/{$v}");
                    }
                }

                // 拷贝components文件
                $componentsPath = __DIR__ . '/react/components/';
                if (is_dir($componentsPath)) {
                    // 检测是否已存在此api文件
                    $compontentsFiles = self::getAllFiles($componentsPath);
                    foreach ($compontentsFiles as $v) {
                        copy($componentsPath . $v, base_path() . "/public/admin_react/src/components/{$v}");
                    }
                }

                // 拷贝pages页面
                $pagesPath = __DIR__ . '/react/pages/';
                if (is_dir($pagesPath)) {
                    $pagesFolderNames = self::getFolderNames($pagesPath);
                    foreach ($pagesFolderNames as $v) {
                        copy_dir($pagesPath . $v, base_path() . "/public/admin_react/src/pages/{$v}");
                    }
                }

            }
        } catch (\Exception $e) {
            echo "{$e->getMessage()}\n";
            echo "安装失败，请删除依赖》解决问题》重新安装\n";
        }

    }

    /**
     * Uninstall
     * @return void
     */
    public static function uninstall()
    {
        // 删除插件
        $pluginFolderNames = self::getFolderNames(__DIR__ . "/plugin");
        foreach ($pluginFolderNames as $v) {
            remove_dir(base_path() . "/plugin/{$v}");
        }

        // 删除api文件
        $apiPath = __DIR__ . '/react/api/';
        if (is_dir($apiPath)) {
            // 检测是否已存在此api文件
            $apiFiles = self::getAllFiles($apiPath);
            foreach ($apiFiles as $v) {
                unlink(base_path() . "/public/admin_react/src/api/{$v}");
            }
        }

        // 删除components文件
        $componentsPath = __DIR__ . '/react/components/';
        if (is_dir($componentsPath)) {
            $compontentsFiles = self::getAllFiles($componentsPath);
            foreach ($compontentsFiles as $v) {
                unlink(base_path() . "/public/admin_react/src/components/{$v}");
            }
        }

        // 删除pages页面
        $pagesPath = __DIR__ . '/react/pages/';
        if (is_dir($pagesPath)) {
            $pagesFolderNames = self::getFolderNames($pagesPath);
            foreach ($pagesFolderNames as $v) {
                remove_dir("/public/admin_react/src/pages/{$v}");
            }
        }

    }

    /**
     * 安装前检测是否满足
     * @return void
     */
    public static function installDetection()
    {
        // 是否能成功安装
        $result = true;

        // 插件的目录
        $pluginPath = base_path() . '/plugin';

        // 插件目录不存在则直接创建，存在则判断跟安装的插件目录是否有冲突
        if (! is_dir($pluginPath)) {
            mkdir($pluginPath, 0777, true);
        } else {
            $pluginFolderNames = self::getFolderNames(__DIR__ . '/plugin');
            foreach ($pluginFolderNames as $v) {
                if (is_dir("{$pluginPath}/{$v}")) {
                    echo "安装失败：插件目录plugin中已经存在{$v}\n";
                    $result = false;
                }
            }
        }

        // 检测react中需要的文件或目录是否满足 // 

        // 检测api文件是否有冲突
        $apiPath = __DIR__ . '/react/api/';
        if (is_dir($apiPath)) {
            $tmp = base_path() . '/public/admin_react/src/api';
            if (! is_dir($tmp)) {
                echo "安装失败：目录不存在public/admin_react/src/api，说明react源码被搬家了\n";
                $result = false;
            } else {
                // 检测是否已存在此api文件
                $apiFiles = self::getAllFiles($apiPath);
                foreach ($apiFiles as $v) {
                    $tmp = base_path() . '/public/admin_react/src/api/' . $v;
                    if (file_exists($tmp) && is_file($tmp)) {
                        echo "安装失败：public/admin_react/src/api中已经存在{$v}\n";
                        $result = false;
                    }
                }
            }
        }

        // 检测components目录是否有冲突
        $componentsPath = __DIR__ . '/react/components/';
        if (is_dir($componentsPath)) {
            $tmp = base_path() . '/public/admin_react/src/components';
            if (! is_dir($tmp)) {
                mkdir($tmp, 0777, true);
            } else {
                $compontentsFiles = self::getAllFiles($componentsPath);
                foreach ($compontentsFiles as $v) {
                    // 检测是否已存在此最贱
                    $tmp = base_path() . '/public/admin_react/src/components/' . $v;
                    if (file_exists($tmp) && is_file($tmp)) {
                        echo "安装失败：public/admin_react/src/components中已经存在{$v}组件\n";
                        $result = false;
                    }
                }
            }
        }

        // 检测pages目录是否有冲突
        $pagesPath = __DIR__ . '/react/pages/';
        if (is_dir($pagesPath)) {
            $tmp = base_path() . '/public/admin_react/src/pages';
            if (! is_dir($tmp)) {
                echo "安装失败：目录不存在public/admin_react/src/pages，说明reanct源码被搬家了\n";
                $result = false;
            } else {
                $pagesFolderNames = self::getFolderNames($pagesPath);
                foreach ($pagesFolderNames as $v) {
                    $tmp = base_path() . '/public/admin_react/src/pages/' . $v;
                    if (is_dir($tmp)) {
                        echo "安装失败：public/admin_react/src/pages目录下已存在{$v}\n";
                        $result = false;
                    }
                }
            }
        }
        return $result;
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
        foreach ($sqlStatements as $sqlStatement) {
            // 去除语句前后的空白字符
            $sqlStatement = trim($sqlStatement);
            // 跳过空语句
            if (empty($sqlStatement)) {
                continue;
            }
            Db::query($sqlStatement);
        }
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
     * 提炼menu.sql中的插入权限节点的所有的name，卸载的时候用来删除
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
            if (strpos($sql, "INSERT INTO `sa_admin_menu`" === false)) {
                continue;
            }

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
}