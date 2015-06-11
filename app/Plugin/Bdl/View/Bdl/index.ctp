<ul>
    <li><?= $this->Html->link('Kategorie', array(
            'controller' => 'Kategorie',
            'action' => 'list',
        )) ?></li>
    <li><?= $this->Html->link('Grupy', array(
            'controller' => 'grupy',
            'action' => 'list',
        )) ?></li>
    <li><?= $this->Html->link('Podgrupy', array(
            'controller' => 'Podgrupy',
            'action' => 'index',
        )) ?></li>

</ul>