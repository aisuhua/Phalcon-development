"use strict";

/**
 * Controller "IndexController"
 *
 * @dependencies $scope global controller variables
 * @dependencies $rootScope global variables
 * @dependencies $http http ajax service
 * @dependencies $location url service
 * @dependencies $sce sanitize HTML service
 */
phlModule.controller('IndexCtrl', ['$scope', '$rootScope', '$http', '$location', '$sce',
    function($scope, $rootScope, $http, $location, $sce) {

    /**
     *	Perform a GET request on the API and pass the slug to it using $location.url()
     *	On success, pass the data to the view through $scope.trusty
     */
    $http.get($location.url())
        .success(function(data){

            $scope.trusty = function() {

                return $sce.trustAsHtml(data.content);
            }

            // Inject the basic elements into the rootScope
            $rootScope.title = data.title;
            $rootScope.topmenu = data.topmenu;

        })
        .error(function(){

            // redirect to not found page
            $location.url('/error/notFound');

        });
}]);