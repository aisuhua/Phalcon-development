'use strict';

(function (angular) {

    /**
     * Session service
     */
    angular.module('app.common')
        .service('Meta',  ['$translate', '$rootScope', function($translate, $rootScope) {

        return {

            /**
             * Set page title
             *
             * @param key
             * @returns {*}
             */
            setTitle: function (newTitle, oldTitle) {

                $translate(newTitle).then(function (newTitle) {
                    $rootScope.title = newTitle;
                });

                $rootScope.$on('$translateChangeSuccess', function () {
                    $translate(newTitle).then(function (newTitle) {

                        if(!_.isUndefined(oldTitle) === true) {
                            // hack to disable reload basic title
                            $rootScope.title = newTitle;
                        }
                    });
                });
            }
        };
    }]);
})(angular);