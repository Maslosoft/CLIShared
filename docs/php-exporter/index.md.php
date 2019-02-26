<?php

use Maslosoft\Cli\Shared\Helpers\PhpExporter;
use Maslosoft\Zamm\Capture;
use Maslosoft\Zamm\DocBlock;
use Maslosoft\Zamm\ShortNamer;

$n = new ShortNamer(PhpExporter::class);
ShortNamer::defaults()->md;
?>
<title>Pretty Print PHP Exporter</title>

# PHP Exporter

The <?= $n; ?> class can be used to export PHP data
into parsable string, additionally nicely indented
just like if it was written by hand. In other words
the <?= $n; ?> class outputs pretty-print version
of `var_dump`.

This can be used for tools generating code, or
ad-hoc to create data structures to include
in your code.

The PHP Exporter class contains only one static
function <?= $n->export(); ?> taking as mandatory
argument the data to be exported, an optional
header and optional template.

The output of function is compatible with
PHP's built-in `var_export`, it is just
nicely printed.

Exporting object states is optimized to
only export properties that are not *private*
and have value different than defined in class.
The optimization was added when project was
used for generating exports to files *en masse*
which turned out to be significant improvement.

## Using PHP Exporter

<?php
echo (new DocBlock(PhpExporter::class))->export();
?>

## Live examples

This example is executed here, right now. It shows how
to use PHP Exporter as well the result of function
with default options.

<?php
Capture::open();
$data = [
	'my-array' => [
		'with' => [
			'sub' => [
				'elements'
			]
		]
	]
];
$exported = PhpExporter::export($data, 'Auto generated');
echo Capture::close()->md;
?>

And the resulting code, that is contents of `$exported` variable.
Notice that the numeric key was added, it is expected behavior.
The result of this function is **string** which is parsable by PHP:

```plain
<?= $exported; ?>
```

# Using custom template

The most simple template might contain just `%s` placeholder. This
example features exporting object instance:

<?php
Capture::open();
class MyExportedClass
{
    public $foo = 'bar';
    public $name = '';
}
$object = new MyExportedClass;
$object->foo = 'x';
$data = [
	'my-array' => [
		'with' => [
			'sub' => [
				'elements'
			]
		]
	],
    'with-class' => $object
];
$exported = PhpExporter::export($data, null, '%s');
echo Capture::close()->md;
?>

And the resulting array will just contain plain data structure as a **string**.
Notice that the `name` property is **not** exported because it was changed:

```plain
<?= $exported; ?>

```
