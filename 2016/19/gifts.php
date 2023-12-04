<?php

require_once '../../autoload.php';
require_once '../../functions.php';

require_once 'CircularLinkedList.php';


//$numElves = 5;
$numElves = 3017957;

$elves = new ElfList($numElves);

$current = $elves->find(1);

while ($elves->count() > 1) {
    $current->data['gifts'] += $current->next->data['gifts'];
    $elves->deleteNode($current->next->data);
    $current = $current->next;
//    output('Remaining: ' . $elves->count());
}

var_export($current->data);

/*


cll = CircularLinkedList()

last = cll.addToEmpty(6)
last = cll.addEnd(8)
last = cll.addFront(2)
last = cll.addAfter(10, 2)

cll.traverse()

last = cll.deleteNode(last, 8)
print()
cll.traverse()



$cll = new CircularLinkedList();

$last = $cll->addToEmpty(6);
$last = $cll->addEnd(8);
$last = $cll->addFront(2);
$last = $cll->addAfter(10, 2);

$cll->traverse();

$last = $cll->deleteNode(10);
echo PHP_EOL;
$cll->traverse();
 */
