<div class="inlineblock button">
    <a ng-click="setTabType('storage');"><?php p($l->t('storage')); ?></a>
</div>
<div class="inlineblock button">
    <a ng-click="setTabType('activity');"><?php p($l->t('activities')); ?></a>
</div>

<h1>{{ Charts.tabType }} <?php p($l->t('usage')); ?></h1>
<p>
    <?php echo $l->t('chart_description'); ?>
</p>
<div id="chartContainer" style="clear: both; height: 300px; width: 99%;"></div>