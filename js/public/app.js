var app = angular.module('Statistics', [
    'ngRoute',
    'ngResource'
]);

app.factory('UserList', function ($resource) {
    var resourceUserList = $resource('users/list', []);
    return resourceUserList.query();
});

angular.module('Statistics').factory('Selected', [function() {
        var Selected = {};
        Selected.day = 30;
        Selected.users = [];
        Selected.unitOfMeasurement = 'mb';

        Selected.selectUnitOfMeasurement = function(unitOfMeasurement)
        {
            Selected.unitOfMeasurement = unitOfMeasurement;
        }

        Selected.selectDay = function(day)
        {
            Selected.day = day;
        }
        Selected.addUser = function(user) {
            Selected.users.push(user);
        }

        Selected.removeUser = function(user) {
            // Remove user
            Selected.users.splice(
                Selected.users.indexOf(user),
                1
            );
        }
        return Selected;
    }
    ]
);

app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});

app.controller('StatisticsController', function($scope, $resource, $q, Selected, UserList) {
        var controllerData = this;
        controllerData.allUsers = UserList;

        controllerData.selectedUsers = Selected.users;
        controllerData.tabType = "storage";
        $scope.currentPage = 0;
        $scope.pageSize = 20;

        $scope.numberOfPages = function() {
            return Math.ceil(controllerData.allUsers.length / $scope.pageSize);
        }
        $scope.setTabType = function(tab) {
            controllerData.tabType = tab;
            $scope.rewriteForAllUsers();
        };

        $scope.selectUser = function(user) {
            // Remove user
            controllerData.allUsers.splice(
                controllerData.allUsers.indexOf(user),
                1
            );

            Selected.addUser(user);
            $scope.addToGraph([user.name]);
        }

        $scope.removeFromSelection = function(user) {
            Selected.removeUser(user);

            // Add User
            controllerData.allUsers.push(user);
            $scope.removeFromGraph(user.name);
        }

        $scope.selectedDay = Selected.day;
        $scope.unitOfMeasurement = Selected.unitOfMeasurement;
        $scope.unitOfMeasurementText = $('#sizes_' + Selected.unitOfMeasurement).text();

        $scope.selectUnitOfMeasurement = function(unitOfMeasurement) {
            $scope.unitOfMeasurement = unitOfMeasurement;
            $scope.unitOfMeasurementText = $('#sizes_' + unitOfMeasurement).text();
            Selected.selectUnitOfMeasurement(unitOfMeasurement);
            $scope.rewriteForAllUsers();
        }
        $scope.selectDay = function(day) {
            $scope.selectedDay = day;
            Selected.selectDay(day);
            $scope.rewriteForAllUsers();
        }

        $scope.day = Selected.day;
        $scope.users = Selected.users;

        var data = [];

        var chart = new CanvasJS.Chart("chartContainer", {
            data: data
        });

        $scope.rewriteForAllUsers = function()
        {
            var userList = [];
            for(var i = 0; i < $scope.users.length; i++)
            {
                $scope.removeFromGraph($scope.users[i].name);
                userList.push($scope.users[i].name);
            }
            $scope.addToGraph(userList);
        }

        $scope.removeFromGraph = function(userName)
        {
            for (var i = 0; i < data.length; i++) {
                if ( data[i].legendText === userName )
                {
                    data.splice(i, 1);
                }
            }
            chart.render();
        }

        $scope.addToGraph = function(userList) {
            var dateTo = new Date();
            var dateToFormatted = dateTo.getDate() + "-" + (dateTo.getMonth() + 1) + "-" + dateTo.getFullYear() + " " + dateTo.getHours() + ":" + dateTo.getMinutes() + ":" + dateTo.getSeconds();
            var dateFrom = new Date();
            dateFrom.setDate(dateTo.getDate() - Selected.day);
            var dateFromFormatted = dateFrom.getDate() + "-" + (dateFrom.getMonth() + 1) + "-" + dateFrom.getFullYear() + " " + dateFrom.getHours() + ":" + dateFrom.getMinutes() + ":" + dateFrom.getSeconds();
            var graphData = $resource('graph/data/:tabType?users=:users&dateFrom=:dateFrom&dateTo=:dateTo', {tabType:controllerData.tabType, users:userList.join(','), dateFrom:dateFromFormatted, dateTo:dateToFormatted,unit:Selected.unitOfMeasurement});
            graphData.query(function(response) {
                for(var k = 0; k < userList.length; k++) {
                    var dataPoints = [];

                    var userName = userList[k];
                    for (var i = 0; i < response.length; i++) {
                        if ( userName !== response[i].username) continue;

                        var dateTime = new Date();
                        dateTime.setDate(response[i].day);
                        dateTime.setMonth(response[i].month - 1);
                        dateTime.setFullYear(response[i].year);
                        dateTime.setHours(response[i].hour);
                        dateTime.setMinutes(response[i].minute);

                        if (controllerData.tabType == 'storage') {
                            dataPoints.push({
                                label: $('#sizes_' + Selected.unitOfMeasurement).text(),
                                x: dateTime,
                                y: response[i].usage
                            });
                        }
                        else {
                            dataPoints.push({
                                x: dateTime,
                                y: response[i].activities
                            });
                        }
                    }
                    data.push(
                        {
                            legendText: userName,
                            showInLegend: true,
                            color: '#' + intToRGB(hashCode(userName)),
                            type: "line",
                            dataPoints: dataPoints
                        }
                    );
                }
                chart.render();

            });
        }

        // default load the logged in user
        $q.all([
            controllerData.allUsers.$promise
        ]).then(function() {
                for (var i = 0; i < controllerData.allUsers.length; i++) {
                    if ( controllerData.allUsers[i].name == OC.currentUser) {
                        $scope.selectUser(controllerData.allUsers[i]);
                    }
                }
            }
        );
    }
);

function hashCode(str) {
    var hash = 0;
    for (var i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    return hash;
}

function intToRGB(i){
    var c = (i & 0x00FFFFFF)
        .toString(16)
        .toUpperCase();

    return "00000".substring(0, 6 - c.length) + c;
}