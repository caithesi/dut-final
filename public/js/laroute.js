(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://new-shop.test',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"sanctum\/csrf-cookie","name":null,"action":"Laravel\Sanctum\Http\Controllers\CsrfCookieController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"test","name":null,"action":"App\Http\Controllers\Test@show"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"App\Http\Controllers\Admin\AdminController@loginAdmin"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"App\Http\Controllers\Admin\AdminController@postLoginAdmin"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"dashboard","action":"App\Http\Controllers\Admin\AdminController@dashboard"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/menu","name":"menu.index","action":"App\Http\Controllers\Admin\MenuController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/menu\/create","name":"menu.create","action":"App\Http\Controllers\Admin\MenuController@create"},{"host":null,"methods":["POST"],"uri":"admin\/menu","name":"menu.store","action":"App\Http\Controllers\Admin\MenuController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/menu\/{menu}","name":"menu.show","action":"App\Http\Controllers\Admin\MenuController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/menu\/{menu}\/edit","name":"menu.edit","action":"App\Http\Controllers\Admin\MenuController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"admin\/menu\/{menu}","name":"menu.update","action":"App\Http\Controllers\Admin\MenuController@update"},{"host":null,"methods":["DELETE"],"uri":"admin\/menu\/{menu}","name":"menu.destroy","action":"App\Http\Controllers\Admin\MenuController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/category","name":"category.index","action":"App\Http\Controllers\Admin\CategoryController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/category\/create","name":"category.create","action":"App\Http\Controllers\Admin\CategoryController@create"},{"host":null,"methods":["POST"],"uri":"admin\/category","name":"category.store","action":"App\Http\Controllers\Admin\CategoryController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/category\/{category}","name":"category.show","action":"App\Http\Controllers\Admin\CategoryController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/category\/{category}\/edit","name":"category.edit","action":"App\Http\Controllers\Admin\CategoryController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"admin\/category\/{category}","name":"category.update","action":"App\Http\Controllers\Admin\CategoryController@update"},{"host":null,"methods":["DELETE"],"uri":"admin\/category\/{category}","name":"category.destroy","action":"App\Http\Controllers\Admin\CategoryController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/product","name":"product.index","action":"App\Http\Controllers\Admin\ProductController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/product\/create","name":"product.create","action":"App\Http\Controllers\Admin\ProductController@create"},{"host":null,"methods":["POST"],"uri":"admin\/product","name":"product.store","action":"App\Http\Controllers\Admin\ProductController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/product\/{product}","name":"product.show","action":"App\Http\Controllers\Admin\ProductController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/product\/{product}\/edit","name":"product.edit","action":"App\Http\Controllers\Admin\ProductController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"admin\/product\/{product}","name":"product.update","action":"App\Http\Controllers\Admin\ProductController@update"},{"host":null,"methods":["DELETE"],"uri":"admin\/product\/{product}","name":"product.destroy","action":"App\Http\Controllers\Admin\ProductController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"logs","name":null,"action":"Rap2hpoutre\LaravelLogViewer\LogViewerController@index"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

