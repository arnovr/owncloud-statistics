<div id="chart-settings" style="display: none; width: 100%;">
    <div class="blockleft">
        <a ng-class="{'active':selectedDay === 1}" ng-click="selectDay(1);"><?php p($l->t('selectday_1')); ?></a><br/>
        <a ng-class="{'active':selectedDay === 7}" ng-click="selectDay(7);"><?php p($l->t('selectday_7')); ?></a><br/>
        <a ng-class="{'active':selectedDay === 30}" ng-click="selectDay(30);"><?php p($l->t('selectday_30')); ?></a><br/>
    </div>
    <div ng-show="Charts.tabType == 'storage'">
        <div class="blockleft">
            <a ng-class="{'active':unitOfMeasurement === 'kb'}" ng-click="selectUnitOfMeasurement('kb');"><?php p($l->t('sizes_kb')); ?></a><br/>
            <a ng-class="{'active':unitOfMeasurement === 'mb'}" ng-click="selectUnitOfMeasurement('mb');"><?php p($l->t('sizes_mb')); ?></a><br/>
            <a ng-class="{'active':unitOfMeasurement === 'gb'}" ng-click="selectUnitOfMeasurement('gb');"><?php p($l->t('sizes_gb')); ?></a><br/>
        </div>
    </div>
</div>
<div style="clear: both;" class="icon-triangle-s" id="toggle"></div>