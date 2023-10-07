<?php
require_once "config.php";
require_once "plugin/phpcode/autoload.php";

use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Filter;

/**
 * 定义请求结束时执行的函数
 * @param CodeCoverage $coverage
 * @return void
 * @throws ReflectionException
 */
function __coverage_stop(CodeCoverage $coverage)
{
    $coverage->stop();
    //停止统计
    $writer = new \SebastianBergmann\CodeCoverage\Report\PHP();
    // 设置生成代码覆盖率页面的路径
    $file_name = substr(md5(uniqid()), 0, 10);
    $writer->process($coverage, dirname(__FILE__) . '/tmp/coverage/'. $file_name .'.cov');
}

if ($config['enable_coverage'])
{
    $coverage  = new CodeCoverage();
    $local_dir = dirname(__FILE__);

    if ($config['while_dirs'])
    {
        foreach ($config['while_dirs'] as $dir)
        {
            $coverage->filter()->addDirectoryToWhitelist($local_dir.'/'.$dir);
        }
    }

    if ($config['while_files'])
    {
        foreach ($config['while_files'] as $file)
        {
            $coverage->filter()->addDirectoryToWhitelist($local_dir.'/'.$file);
        }
    }
    $coverage->start('coverage');
    register_shutdown_function('__coverage_stop', $coverage);
}
