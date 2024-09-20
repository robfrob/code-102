<?php

// разделение html шаблона и данных
// краткий конструктор
// рефлексия
// атрибуты
// магические константы
// синтаксис ::class
// функция current - получение 1го елемента массива
// array_filter и стрелочная функция
// приведение типов array -> bool

class Runner
{
    public static function main()
    {
        $db = new DB();
        $view = new SelectorTableView();
        $runner = new Runner($db, $view);
        $runner->runSelectors();
    }

    // https://stitcher.io/blog/constructor-promotion-in-php-8
    public function __construct(private $db, private $view)
    {
    }

    public function runSelectors()
    {
        $this->view->renderStyles();
        foreach ($this->listSelectors() as $refMethod) {
            $this->view->renderMethod(
                $refMethod->getName(),
                $refMethod->invoke($this->db)
            );
        }
    }

    public function listSelectors()
    {
        // https://www.hashbangcode.com/article/introduction-object-reflection-php
        // https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class
	// https://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting
        $refObject = new ReflectionObject($this->db);
        return array_filter(
            $refObject->getMethods(),
            fn($refMethod) => $refMethod->getAttributes(Selector::class)
        );
    }
}

// https://stitcher.io/blog/attributes-in-php-8
#[Attribute]
class Selector
{
}

class DB
{
    public static function select1()
    {
    }

    private static function select2()
    {
    }

    // https://stitcher.io/blog/attributes-in-php-8
    #[Selector]
    public function select31()
    {
        // https://www.php.net/manual/en/language.constants.magic.php
        return $this->select(__FUNCTION__);
    }

    #[Selector]
    public function select32()
    {
        return $this->select(__FUNCTION__);
    }

    #[Selector]
    public function select33()
    {
        return $this->select(__FUNCTION__);
    }

    private function select($queryName)
    {
        return [
            [
                "column_a" => $queryName . "_value_a1",
                "column_b" => $queryName . "_value_b1",
                "column_c" => $queryName . "_value_c1"
            ],
            [
                "column_a" => $queryName . "_value_a2",
                "column_b" => $queryName . "_value_b2",
                "column_c" => $queryName . "_value_c2"
            ],
        ];
    }
}

class SelectorTableView
{
    public function renderStyles()
    {
        ?>
		<style>
			caption:before {
				content: "Result of execution Sql query <" ;
			}
			
			caption:after {
				content: ">" ;
			}
			
			caption {
			  caption-side: top;
			  text-align: left;
			  text-transform: capitalize;
			  padding-bottom: 10px;
			  font-weight: bold;
			}
			
			table {
			  border-collapse: collapse;
			  border: 2px solid rgb(140 140 140);
			  font-family: sans-serif;
			  font-size: 0.8rem;
			  letter-spacing: 1px;
			  margin-bottom: 20px;
			}
			
			th,
			td {
			  border: 1px solid rgb(160 160 160);
			  padding: 8px 10px;
			}
			
			th {
			  background-color: rgb(230 230 230);
			}
			
			th,
			td {
			  text-align: center;
			}
			</style>
		<?php
    }

    public function renderMethod($methodName, $rows)
    {
        $this->renderOpenTableTag();
        $this->renderCaption($methodName);
        $this->renderTableHead($rows);
        $this->renderTableBody($rows);
        $this->renderCloseTableTag();
    }

    private function renderOpenTableTag()
    {
        ?>
		<table>
		<?php
    }

    private function renderCloseTableTag()
    {
        ?>
		</table>
		<?php
    }

    private function renderCaption($methodName)
    {
        ?>
		<caption>
			<?php echo $methodName; ?>
		</caption>
		<?php
    }

    private function renderTableHead($rows)
    {
        ?>
		<thead>
			<?php foreach (current($rows) as $columnName => $columnValue): ?>
				<th>
					<?php echo $columnName; ?>
				</th>
			<?php endforeach; ?>
		</thead>
		<?php
    }

    private function renderTableBody($rows)
    {
        ?>
		<tbody>
			<?php foreach ($rows as $row): ?>
				<tr>
					<?php foreach ($row as $columnValue): ?>
						<td>
							<?php echo $columnValue; ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<?php
    }
}

Runner::main();
