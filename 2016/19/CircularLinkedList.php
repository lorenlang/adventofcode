<?php

class Node
{

    public $data;
    public Node $next;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function getDataAttribute($attribute)
    {
        return $this->data[$attribute];
    }


    public function setDataAttribute($attribute, $value)
    {
        $this->data[$attribute] = $value;
        return $this;
    }

}

class CircularLinkedList implements Countable
{

    public $last;
    public $numNodes;

    public function __construct()
    {
        $this->last     = NULL;
        $this->numNodes = 0;
    }


    public function count(): int
    {
        return $this->numNodes;
    }


    public function addToEmpty($data)
    {

        if ($this->last !== NULL) {
            return $this->last;
        }

        // instantiate a new node and add data to it
        // assign last to newNode
        $this->last = new Node($data);

        // create link to itself
        $this->last->next = $this->last;

        // increment the number of nodes
        $this->numNodes++;

        return $this->last;
    }


    public function addFront($data)
    {
        // check if the list is empty
        if ($this->last === NULL) {
            return $this->addToEmpty($data);
        }

        // instantiate a new node and add data to it
        $newNode = new Node($data);

        // store the address of the current first node in the newNode
        $newNode->next = $this->last->next;

        // make newNode as last
        $this->last->next = $newNode;

        // increment the number of nodes
        $this->numNodes++;

        return $this->last;
    }


    public function addEnd($data)
    {
        // check if the list is empty
        if ($this->last === NULL) {
            return $this->addToEmpty($data);
        }

        // instantiate a new node and add data to it
        $newNode = new Node($data);

        // store the address of the last node to next of newNode
        $newNode->next = $this->last->next;

        // point the current last node to the newNode
        $this->last->next = $newNode;

        // make newNode as the last node
        $this->last = $newNode;

        // increment the number of nodes
        $this->numNodes++;

        return $this->last;
    }


    public function addAfter($data, $item)
    {
        // check if the list is empty
        if ($this->last === NULL) {
            return NULL;
        }

        // instantiate a new node and add data to it
        $newNode = new Node($data);

        // point to the first node
        $p = $this->last->next;
        while ($p) {

            // if the item is found, place newNode after it
            if ($p->data === $item) {

                // make the next of the current node as the next of newNode
                $newNode->next = $p->next;

                // put newNode to the next of p
                $p->next = $newNode;

                if ($p === $this->last) {
                    $this->last = $newNode;
                    // increment the number of nodes
                    $this->numNodes++;

                    return $this->last;
                } else {
                    // increment the number of nodes
                    $this->numNodes++;

                    return $this->last;
                }
            }
            $p = $p->next;
            if ($p === $this->last->next) {
//                echo $item . "The given node is not present in the list";
                break;
            }
        }
    }


    public function deleteNode($key)
    {
        // check if the list is empty
        if ($this->last === NULL) {
            return NULL;
        }

        // if the list contains only a single node
        if ($this->last->data === $key && $this->last->next === $this->last) {
            $this->last = NULL;
            return $this->last;
        }

        $temp = $this->last;
        $d    = NULL;

        // if last node is to be deleted
        if ($this->last->data === $key) {

            // find the node before the last node
            while ($temp->next !== $this->last) {
                $temp = $temp->next;
            }

            // point temp node to the next of last i.e. first node
            $temp->next = $this->last->next;
            $this->last = $temp->next;
        }

        // travel to the node to be deleted
        while ($temp->next !== $this->last && $temp->next->data !== $key) {
            $temp = $temp->next;
        }

        // if node to be deleted was found
        if ($temp->next->data === $key) {
            $d          = $temp->next;
            $temp->next = $d->next;
        }

        // decrement the number of nodes
        $this->numNodes--;

        return $this->last;
    }


    public function traverse()
    {
        if ($this->last === NULL) {
//            echo "The list is empty";
            return;
        }

        $newNode = $this->last->next;
        while ($newNode) {
//            echo $newNode->data . " ";
            $newNode = $newNode->next;
            if ($newNode === $this->last->next) {
                break;
            }
        }
    }
}


class ElfList extends CircularLinkedList
{

//    public $current;

    public function __construct($numElves)
    {
        parent::__construct();

        for ($i = 1; $i <= $numElves; $i++) {
            $this->addEnd(['num' => $i, 'gifts' => 1]);
//            if ($i === 1) {
//                $this->current = $this->last;
//            }
        }
    }


    public function find($num)
    {
        $node = $this->last->next;
        while ($node) {
            if ($node->data['num'] === $num) {
                return $node;
            }
            $node = $node->next;
            if ($node === $this->last->next) {
                break;
            }
        }
        return NULL;
    }


}
