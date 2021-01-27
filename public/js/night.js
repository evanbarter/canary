/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/nightwind/helper.js":
/*!******************************************!*\
  !*** ./node_modules/nightwind/helper.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = {\n  init: () => {\n    const codeToRunOnClient = `\n      (function() {\n        function getInitialColorMode() {\n                const persistedColorPreference = window.localStorage.getItem('nightwind-mode');\n                const hasPersistedPreference = typeof persistedColorPreference === 'string';\n                if (hasPersistedPreference) {\n                  return persistedColorPreference;\n                }\n                const mql = window.matchMedia('(prefers-color-scheme: dark)');\n                const hasMediaQueryPreference = typeof mql.matches === 'boolean';\n                if (hasMediaQueryPreference) {\n                  return mql.matches ? 'dark' : 'light';\n                }\n                return 'light';\n        }\n        getInitialColorMode() == 'light' ? document.documentElement.classList.remove('dark') : document.documentElement.classList.add('dark');\n        document.documentElement.classList.add('nightwind');\n      })()\n    `;\n    return codeToRunOnClient;\n  },\n\n  toggle: () => {\n    if (!document.documentElement.classList.contains('dark')) {\n      document.documentElement.classList.add('dark');\n      window.localStorage.setItem('nightwind-mode', 'dark');\n    } else {\n        document.documentElement.classList.remove('dark');\n        window.localStorage.setItem('nightwind-mode', 'light');\n    }\n  },\n\n  // Old\n\n  checkNightMode: () => {\n    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;\n  },\n\n  watchNightMode: () => {\n    if (!window.matchMedia) return;\n    window.matchMedia('(prefers-color-scheme: dark)').addListener(module.exports.addNightModeSelector());\n  },\n\n  addNightModeSelector: () => {\n    if (module.exports.checkNightMode()) {\n      document.documentElement.classList.add('dark');\n    } else {\n      document.documentElement.classList.remove('dark');\n    }\n  },\n\n  addNightTransitions: () => {\n    if (!document.documentElement.classList.contains('nightwind')) {\n      document.documentElement.classList.add('nightwind');\n    }\n  },\n\n  initNightwind: () => {\n    module.exports.watchNightMode();\n    module.exports.addNightModeSelector();\n    module.exports.addNightTransitions();\n  },\n\n  toggleNightMode: () => {\n    if (!document.documentElement.classList.contains('dark')) {\n      document.documentElement.classList.add('dark');\n      window.localStorage.setItem('nightwind-mode', 'dark');\n    } else {\n        document.documentElement.classList.remove('dark');\n        window.localStorage.setItem('nightwind-mode', 'light');\n    }\n  },\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbmlnaHR3aW5kL2hlbHBlci5qcz8yNmViIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBLEdBQUc7O0FBRUg7O0FBRUE7QUFDQTtBQUNBLEdBQUc7O0FBRUg7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBLEdBQUc7O0FBRUg7QUFDQTtBQUNBO0FBQ0E7QUFDQSxHQUFHOztBQUVIO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0giLCJmaWxlIjoiLi9ub2RlX21vZHVsZXMvbmlnaHR3aW5kL2hlbHBlci5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIm1vZHVsZS5leHBvcnRzID0ge1xuICBpbml0OiAoKSA9PiB7XG4gICAgY29uc3QgY29kZVRvUnVuT25DbGllbnQgPSBgXG4gICAgICAoZnVuY3Rpb24oKSB7XG4gICAgICAgIGZ1bmN0aW9uIGdldEluaXRpYWxDb2xvck1vZGUoKSB7XG4gICAgICAgICAgICAgICAgY29uc3QgcGVyc2lzdGVkQ29sb3JQcmVmZXJlbmNlID0gd2luZG93LmxvY2FsU3RvcmFnZS5nZXRJdGVtKCduaWdodHdpbmQtbW9kZScpO1xuICAgICAgICAgICAgICAgIGNvbnN0IGhhc1BlcnNpc3RlZFByZWZlcmVuY2UgPSB0eXBlb2YgcGVyc2lzdGVkQ29sb3JQcmVmZXJlbmNlID09PSAnc3RyaW5nJztcbiAgICAgICAgICAgICAgICBpZiAoaGFzUGVyc2lzdGVkUHJlZmVyZW5jZSkge1xuICAgICAgICAgICAgICAgICAgcmV0dXJuIHBlcnNpc3RlZENvbG9yUHJlZmVyZW5jZTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgY29uc3QgbXFsID0gd2luZG93Lm1hdGNoTWVkaWEoJyhwcmVmZXJzLWNvbG9yLXNjaGVtZTogZGFyayknKTtcbiAgICAgICAgICAgICAgICBjb25zdCBoYXNNZWRpYVF1ZXJ5UHJlZmVyZW5jZSA9IHR5cGVvZiBtcWwubWF0Y2hlcyA9PT0gJ2Jvb2xlYW4nO1xuICAgICAgICAgICAgICAgIGlmIChoYXNNZWRpYVF1ZXJ5UHJlZmVyZW5jZSkge1xuICAgICAgICAgICAgICAgICAgcmV0dXJuIG1xbC5tYXRjaGVzID8gJ2RhcmsnIDogJ2xpZ2h0JztcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgcmV0dXJuICdsaWdodCc7XG4gICAgICAgIH1cbiAgICAgICAgZ2V0SW5pdGlhbENvbG9yTW9kZSgpID09ICdsaWdodCcgPyBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnZGFyaycpIDogZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsYXNzTGlzdC5hZGQoJ2RhcmsnKTtcbiAgICAgICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsYXNzTGlzdC5hZGQoJ25pZ2h0d2luZCcpO1xuICAgICAgfSkoKVxuICAgIGA7XG4gICAgcmV0dXJuIGNvZGVUb1J1bk9uQ2xpZW50O1xuICB9LFxuXG4gIHRvZ2dsZTogKCkgPT4ge1xuICAgIGlmICghZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsYXNzTGlzdC5jb250YWlucygnZGFyaycpKSB7XG4gICAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuY2xhc3NMaXN0LmFkZCgnZGFyaycpO1xuICAgICAgd2luZG93LmxvY2FsU3RvcmFnZS5zZXRJdGVtKCduaWdodHdpbmQtbW9kZScsICdkYXJrJyk7XG4gICAgfSBlbHNlIHtcbiAgICAgICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsYXNzTGlzdC5yZW1vdmUoJ2RhcmsnKTtcbiAgICAgICAgd2luZG93LmxvY2FsU3RvcmFnZS5zZXRJdGVtKCduaWdodHdpbmQtbW9kZScsICdsaWdodCcpO1xuICAgIH1cbiAgfSxcblxuICAvLyBPbGRcblxuICBjaGVja05pZ2h0TW9kZTogKCkgPT4ge1xuICAgIHJldHVybiB3aW5kb3cubWF0Y2hNZWRpYSAmJiB3aW5kb3cubWF0Y2hNZWRpYSgnKHByZWZlcnMtY29sb3Itc2NoZW1lOiBkYXJrKScpLm1hdGNoZXM7XG4gIH0sXG5cbiAgd2F0Y2hOaWdodE1vZGU6ICgpID0+IHtcbiAgICBpZiAoIXdpbmRvdy5tYXRjaE1lZGlhKSByZXR1cm47XG4gICAgd2luZG93Lm1hdGNoTWVkaWEoJyhwcmVmZXJzLWNvbG9yLXNjaGVtZTogZGFyayknKS5hZGRMaXN0ZW5lcihtb2R1bGUuZXhwb3J0cy5hZGROaWdodE1vZGVTZWxlY3RvcigpKTtcbiAgfSxcblxuICBhZGROaWdodE1vZGVTZWxlY3RvcjogKCkgPT4ge1xuICAgIGlmIChtb2R1bGUuZXhwb3J0cy5jaGVja05pZ2h0TW9kZSgpKSB7XG4gICAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuY2xhc3NMaXN0LmFkZCgnZGFyaycpO1xuICAgIH0gZWxzZSB7XG4gICAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZSgnZGFyaycpO1xuICAgIH1cbiAgfSxcblxuICBhZGROaWdodFRyYW5zaXRpb25zOiAoKSA9PiB7XG4gICAgaWYgKCFkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQuY2xhc3NMaXN0LmNvbnRhaW5zKCduaWdodHdpbmQnKSkge1xuICAgICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsYXNzTGlzdC5hZGQoJ25pZ2h0d2luZCcpO1xuICAgIH1cbiAgfSxcblxuICBpbml0TmlnaHR3aW5kOiAoKSA9PiB7XG4gICAgbW9kdWxlLmV4cG9ydHMud2F0Y2hOaWdodE1vZGUoKTtcbiAgICBtb2R1bGUuZXhwb3J0cy5hZGROaWdodE1vZGVTZWxlY3RvcigpO1xuICAgIG1vZHVsZS5leHBvcnRzLmFkZE5pZ2h0VHJhbnNpdGlvbnMoKTtcbiAgfSxcblxuICB0b2dnbGVOaWdodE1vZGU6ICgpID0+IHtcbiAgICBpZiAoIWRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5jbGFzc0xpc3QuY29udGFpbnMoJ2RhcmsnKSkge1xuICAgICAgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsYXNzTGlzdC5hZGQoJ2RhcmsnKTtcbiAgICAgIHdpbmRvdy5sb2NhbFN0b3JhZ2Uuc2V0SXRlbSgnbmlnaHR3aW5kLW1vZGUnLCAnZGFyaycpO1xuICAgIH0gZWxzZSB7XG4gICAgICAgIGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5jbGFzc0xpc3QucmVtb3ZlKCdkYXJrJyk7XG4gICAgICAgIHdpbmRvdy5sb2NhbFN0b3JhZ2Uuc2V0SXRlbSgnbmlnaHR3aW5kLW1vZGUnLCAnbGlnaHQnKTtcbiAgICB9XG4gIH0sXG59Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./node_modules/nightwind/helper.js\n");

/***/ }),

/***/ "./resources/js/night.js":
/*!*******************************!*\
  !*** ./resources/js/night.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("window.nightwind = __webpack_require__(/*! nightwind/helper */ \"./node_modules/nightwind/helper.js\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvbmlnaHQuanM/ZTFkOSJdLCJuYW1lcyI6WyJ3aW5kb3ciLCJuaWdodHdpbmQiLCJyZXF1aXJlIl0sIm1hcHBpbmdzIjoiQUFBQUEsTUFBTSxDQUFDQyxTQUFQLEdBQW1CQyxtQkFBTyxDQUFDLDREQUFELENBQTFCIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL25pZ2h0LmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsid2luZG93Lm5pZ2h0d2luZCA9IHJlcXVpcmUoJ25pZ2h0d2luZC9oZWxwZXInKVxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/night.js\n");

/***/ }),

/***/ 2:
/*!*************************************!*\
  !*** multi ./resources/js/night.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/evan/Code/Open Source/canary/resources/js/night.js */"./resources/js/night.js");


/***/ })

/******/ });