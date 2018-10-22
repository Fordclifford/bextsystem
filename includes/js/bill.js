var notifyApp = angular.module('notifyApp', ['angular-growl', 'ngAnimate']);

notifyApp.controller('notifyCtrl', ['$scope', 'growl', '$http', function ($scope, growl, $http) {


        $scope.totalbill = function () {
            $http({

                method: 'GET',
                url: 'includes/api/bills.php'

            }).then(function (response) {

                // on success
                //if(isNaN(response.data)){
                var string = response.data,
                        expr = /sumbill/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(7), {title: 'Total Bills'});
               }

            }, function (response) {
//              alert(response.data,response.status);

                // on error
                console.log(response.data, response.status);

            });
        };
        $scope.difference = function () {
            $http({

                method: 'GET',
                url: 'includes/api/incomedifference.php'

            }).then(function (response) {

             
                var string = response.data,
                        expr = /lessby/;  // no quotes here
               if( expr.test(string)){
                growl.error(response.data.slice(6), {title: 'Opps! Your church income is less by'});
               }
               
                var string = response.data,
                        expr = /remaining/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(9), {title: 'Remaining'});
               }
            }, function (response) {
//              alert(response.data,response.status);

                // on error
                console.log(response.data, response.status);

            });
        };
        
           $scope.totalactualincome = function () {
            $http({

                method: 'GET',
                url: 'includes/api/income.php'

            }).then(function (response) {

                var string = response.data,
                        expr = /sumincome/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(9), {title: 'Total Income'});
               }
            }, function (response) {
//              alert(response.data,response.status);

                // on error
                console.log(response.data, response.status);

            });
        };
        
        
        


         $scope.totalbill();
        $scope.totalactualincome();
         $scope.difference();
//        $scope.showAll();
    }]);
