<ul>
    <?php
    foreach ($analyzers as $analyzer) {
        ?>

        <li><?= $this->Html->link($analyzer['Analyzer']['id'], array(
                'controller' => 'Analyzers',
                'action' => 'view',
                'id' => $analyzer['Analyzer']['id'],
            )) ?></li>

    <?
    }
    ?>
</ul>