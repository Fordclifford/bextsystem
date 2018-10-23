var notifyApp = angular.module('notifyApp', ['angular-growl', 'ngAnimate']);

notifyApp.controller('notifyCtrl', ['$scope', 'growl', '$http', function ($scope, growl, $http) {


        $scope.totalbill = function () {
            $http({

                method: 'GET',
                url: 'includes/api/bills.php'

            }).then(function (response) {

              var string = response.data,
                        expr = /sumbillokay/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(11), {title: 'Total Bills'});
               }
               var string = response.data,
                        expr = /sumbillzero/;  // no quotes here
               if( expr.test(string)){
                growl.warning(response.data.slice(11), {title: 'No Bills paid!'});
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
                        expr = /remaining/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(9), {title: 'Remaining Balance'});
               }
            }, function (response) {
//              alert(response.data,response.status);

                // on error
                console.log(response.data, response.status);

            });
        };
        
         $scope.balance = function () {
            $http({

                method: 'GET',
                url: 'includes/api/balance.php'

            }).then(function (response) {

                var string = response.data,
                        expr = /output/;  // no quotes here
               if( expr.test(string)){
                growl.error(response.data.slice(6), {title: 'The following sources needs attention'});
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
                        expr = /sumincomeokay/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(13), {title: 'Total Income'});
               }
                var string = response.data,
                        expr = /sumincomezero/;  // no quotes here
               if( expr.test(string)){
                growl.error(response.data.slice(13), {title: 'OOPS! Your church has no income'});
               }
            }, function (response) {
//              alert(response.data,response.status);

                // on error
                console.log(response.data, response.status);

            });
        };
        
        
        



        $scope.totalactualincome();
         $scope.totalbill();
         $scope.difference();
         $scope.balance();
//        $scope.showAll();
    }]);
