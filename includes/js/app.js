var notifyApp = angular.module('notifyApp', ['angular-growl', 'ngAnimate']);

notifyApp.controller('notifyCtrl', ['$scope', 'growl','$http', function ($scope, growl, $http) {
//   $scope.showAll = function () {
//            growl.warning('This is warning mesage.', {title: 'Warning!'});
//            growl.error('This is error mesage.', {title: 'Error!'});
//            growl.success('This is success mesage.', {title: 'Success!'});
//            growl.info('This is an info mesage.', {title: 'Info!'});
//        };
     
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
        $scope.budget = function() {
                 $http({
              
              method: 'GET',
              url: 'includes/api/budget.php'
              
          }).then(function (response) {
              
              // on success
              if(response.data =='expenses_not_exist'){
             growl.warning('Hello! You need to add estimated expenses for your church', {title: 'Warning!'});
         }
          if(response.data =='income_not_exist'){
             growl.warning('Hello! You need to add estimated income for your church', {title: 'Warning!'});
         }
          }, function (response) {
//              alert(response.data,response.status);
              
              // on error
              console.log(response.data,response.status);
              
          });
        };
        
       $scope.fYear();
       $scope.budget();
//        $scope.showAll();
    }]);
