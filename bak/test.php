<?php

// namespace A;

// require("test1.php");
// require("test2.php");
// $c = new A\test1;
// 


namespace A {
	class test1 {}
}

namespace B {
	use A\test1;
	class test2 extends test1{}
}

namespace {
	use A\test1;
	$c = new test1;
}

