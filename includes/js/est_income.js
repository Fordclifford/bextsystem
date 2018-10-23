var notifyApp = angular.module('notifyApp', ['angular-growl', 'ngAnimate']);

notifyApp.controller('notifyCtrl', ['$scope', 'growl', '$http', function ($scope, growl, $http) {


        $scope.totalExpense = function () {
            $http({

                method: 'GET',
                url: 'includes/api/estimate_expenses.php'

            }).then(function (response) {

                // on success
                //if(isNaN(response.data)){
                var string = response.data,
                        expr = /expensesumokay/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(14), {title: 'Total Estimate Expenses'});
               }
                 var string = response.data,
                        expr = /expensesumzero/;  // no quotes here
               if( expr.test(string)){
                growl.warning(response.data.slice(14), {title: 'No estimate expenses this year!'});
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
                url: 'includes/api/budget_difference.php'

            }).then(function (response) {

                var string = response.data,
                        expr = /lessby/;  // no quotes here
               if( expr.test(string)){
                growl.error(response.data.slice(6), {title: 'Estimate Income is Less by'});
               }
               
                var string = response.data,
                        expr = /remaining/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(9)+' in your budget', {title: 'You have an excess of'});
               }
            }, function (response) {
//              alert(response.data,response.status);

                // on error
                console.log(response.data, response.status);

            });
        };
        
           $scope.totalestimateincome = function () {
            $http({

                method: 'GET',
                url: 'includes/api/estimate_income.php'

            }).then(function (response) {

                var string = response.data,
                        expr = /estimateincomeokay/;  // no quotes here
               if( expr.test(string)){
                growl.info(response.data.slice(18), {title: 'Total Estimate Income'});
               }
                  var string = response.data,
                        expr = /estimateincomezero/;  // no quotes here
               if( expr.test(string)){
                growl.warning(response.data.slice(18), {title: 'No estimate income this year'});
               }
            }, function (response) {
//            
                console.log(response.data, response.status);

            });
        };
        
        
        


          
              $scope.totalestimateincome();
             $scope.totalExpense();
          $scope.difference();
//        $scope.showAll();
    }]);
