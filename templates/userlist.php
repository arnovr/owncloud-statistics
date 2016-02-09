<ul>
    <li class="menu-title"><h1><?php p($l->t('title_selected_users')); ?></h1></li>
    <li ng-repeat="user in Charts.selectedUsers | orderBy:'name'">
        <a ng-click="removeFromSelection(user);">{{user.name}}</a>
    </li>

    <li class="padding-left" ng-hide="Charts.selectedUsers.length"><?php p($l->t('no_users_selected')); ?></li>

    <li class="menu-title"><h1><?php p($l->t('title_user_list')); ?></h1></li>
    <li class="padding-left"><input ng-model="query" ng-change="currentPage = 0" class="search icon-search"/></li>
    <li ng-repeat="user in Charts.allUsers | filter:query | orderBy:'name' | startFrom:currentPage*pageSize | limitTo:pageSize">
        <a ng-click="selectUser(user);">{{user.name}}</a>
    </li>
</ul>

<button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
    <?php p($l->t('previous_button')); ?>
</button>
{{currentPage+1}}/{{numberOfPages()}}
<button ng-disabled="currentPage >= data.length/pageSize - 1" ng-click="currentPage=currentPage+1">
    <?php p($l->t('next_button')); ?>
</button>