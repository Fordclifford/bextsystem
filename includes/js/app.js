var notifyApp = angular.module('notifyApp', ['angular-growl', 'ngAnimate']);

notifyApp.controller('notifyCtrl', ['$scope', 'growl','$http', function ($scope, growl, $http) {

     
        $scope.fYear = function() {
                 $http({
              
              method: 'GET',
              url: 'includes/api/fyear.php'
              
          }).then(function (response) {
              
              // on success
              if(response.data !=''){
             growl.success(response.data, {title: 'Success!'});
         }
          }, function (response) {
//              alert(response.data,response.status);
              
              // on error
              console.log(response.data,response.status);
              
          });
        };
        $scope.totalactualincome = function() {
                 $http({
              
              method: 'GET',
              url: 'includes/api/income.php'
              
          }).then(function (response) {
              
              // on success
          //if(isNaN(response.data)){
             growl.info(response.data, {title: 'Total Income'});
         
         
          }, function (response) {
//              alert(response.data,response.status);
              
              // on error
              console.log(response.data,response.status);
              
          });
        };
        
        $scope.income = function() {
                 $http({
              
              method: 'GET',
              url: 'includes/api/income.php'
              
          }).then(function (response) {
              
              // on success
              if(response.data =='actual_not_exist'){
             growl.warning('Hello! You need to add income for your church', {title: 'Warning!'});
         }
         
          }, function (response) {
//              alert(response.data,response.status);
              
              // on error
              console.log(response.data,response.status);
              
          });
        };
        
        $scope.budget = function() {
                 $http({
              
              method: 'GET',
              url: 'includes/api/budget.php'
              
          }).then(function (response) {
              
              // on success
              if(response.data =='expenses_not_exist'){
             growl.danger('Hello! You need to add estimated expenses for your church', {title: 'Alert!'});
         }
          if(response.data =='income_not_exist'){
             growl.danger('Hello! You need to add estimated income for your church', {title: 'Alert!'});
         }
         if(response.data =='income_less'){
             growl.danger('Hello! Your estimated income is less than the expenses!!', {title: 'Alert!'});
         }
          }, function (response) {
//              alert(response.data,response.status);
              
              // on error
              console.log(response.data,response.status);
              
          });
        };
        
       $scope.fYear();
       $scope.budget();
      
       $scope.income();
//        $scope.showAll();
    }]);
