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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/view/table-of-content.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/view/table-of-content.js":
/*!*****************************************!*\
  !*** ./src/js/view/table-of-content.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }\n\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _iterableToArray(iter) { if (typeof Symbol !== \"undefined\" && Symbol.iterator in Object(iter)) return Array.from(iter); }\n\nfunction _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\n(function ($) {\n  jQuery(document).ready(function () {\n    /**\n     * add ID in main content heading tag\n     * @param selector\n     * @param supportTag\n     */\n    function eael_toc_content(selector, supportTag) {\n      var listId = document.getElementById(\"eael-toc-list\");\n\n      if (selector === null || supportTag === undefined || !listId) {\n        return null;\n      }\n\n      var eaelToc = document.getElementById(\"eael-toc\");\n      var titleUrl = typeof eaelToc.dataset.titleurl !== \"undefined\" ? eaelToc.dataset.titleurl : \"false\";\n      var excludeArr = typeof eaelToc.dataset.excludeSelector !== \"undefined\" ? eaelToc.dataset.excludeSelector.replace(/^,|,$/g, \"\") : \"\";\n      var allSupportTag = [];\n      var mainSelector = document.querySelectorAll(selector),\n          listIndex = 0;\n\n      for (var j = 0; j < mainSelector.length; j++) {\n        allSupportTag = [].concat(_toConsumableArray(allSupportTag), _toConsumableArray(mainSelector[j].querySelectorAll(supportTag)));\n      }\n\n      allSupportTag = Array.from(new Set(allSupportTag));\n      allSupportTag.forEach(function (el) {\n        if (eaelTocExclude(excludeArr, el)) {\n          return;\n        }\n\n        el.id = listIndex + \"-\" + eael_build_id(titleUrl, el.textContent);\n        el.classList.add(\"eael-heading-content\");\n        listIndex++;\n      }); //build toc list hierarchy\n\n      eael_list_hierarchy(selector, supportTag, allSupportTag);\n      var firstChild = $(\"ul.eael-toc-list > li\");\n\n      if (firstChild.length < 1) {\n        document.getElementById(\"eael-toc\").classList.add(\"eael-toc-disable\");\n      }\n\n      firstChild.each(function () {\n        this.classList.add(\"eael-first-child\");\n      });\n    }\n    /**\n     * Make toc list\n     * @param selector\n     * @param supportTag\n     */\n\n\n    function eael_list_hierarchy(selector, supportTag, allSupportTagList) {\n      var tagList = supportTag;\n      var allHeadings = allSupportTagList;\n      var eaelToc = document.getElementById(\"eael-toc\");\n      var titleUrl = typeof eaelToc.dataset.titleurl !== \"undefined\" ? eaelToc.dataset.titleurl : \"false\";\n      var listId = document.getElementById(\"eael-toc-list\");\n      var excludeArr = typeof eaelToc.dataset.excludeselector !== \"undefined\" ? eaelToc.dataset.excludeselector.replace(/^,|,$/g, \"\") : \"\";\n      var parentLevel = \"\",\n          baseTag = parentLevel = tagList.trim().split(\",\")[0].substr(1, 1),\n          ListNode = listId;\n      listId.innerHTML = \"\";\n\n      if (allHeadings.length > 0) {\n        document.getElementById(\"eael-toc\").classList.remove(\"eael-toc-disable\");\n      }\n\n      for (var i = 0, len = allHeadings.length; i < len; ++i) {\n        var currentHeading = allHeadings[i];\n\n        if (eaelTocExclude(excludeArr, currentHeading)) {\n          continue;\n        }\n\n        var latestLavel = parseInt(currentHeading.tagName.substr(1, 1));\n        var diff = latestLavel - parentLevel;\n\n        if (diff > 0) {\n          var containerLiNode = ListNode.lastChild;\n\n          if (containerLiNode) {\n            var createUlNode = document.createElement(\"UL\");\n            containerLiNode.appendChild(createUlNode);\n            ListNode = createUlNode;\n            parentLevel = latestLavel;\n          }\n        }\n\n        var sequenceParent = false;\n\n        if (diff < 0) {\n          while (0 !== diff++) {\n            if (ListNode.parentNode.parentNode) {\n              ListNode = ListNode.parentNode.parentNode;\n            }\n          }\n\n          parentLevel = latestLavel;\n          sequenceParent = true;\n        }\n\n        if (ListNode.tagName !== \"UL\") {\n          ListNode = listId;\n        }\n\n        if (currentHeading.textContent.trim() === \"\") {\n          continue;\n        }\n\n        var liNode = document.createElement(\"LI\");\n        var anchorTag = document.createElement(\"A\");\n        var spanTag = document.createElement(\"SPAN\");\n\n        if (baseTag === parentLevel || sequenceParent) {\n          liNode.setAttribute(\"itemscope\", \"\");\n          liNode.setAttribute(\"itemtype\", \"http://schema.org/ListItem\");\n          liNode.setAttribute(\"itemprop\", \"itemListElement\");\n        }\n\n        var Linkid = \"#\" + i + \"-\" + eael_build_id(titleUrl, currentHeading.textContent);\n        anchorTag.className = \"eael-toc-link\";\n        anchorTag.setAttribute(\"itemprop\", \"item\");\n        anchorTag.setAttribute(\"href\", Linkid);\n        spanTag.appendChild(document.createTextNode(currentHeading.textContent));\n        anchorTag.appendChild(spanTag);\n        liNode.appendChild(anchorTag);\n        ListNode.appendChild(liNode);\n      }\n    } // expand collapse\n\n\n    $(document).on(\"click\", \"ul.eael-toc-list a\", function (e) {\n      e.preventDefault();\n      $(document).off(\"scroll\");\n      var target = this.hash;\n      history.pushState(\"\", document.title, window.location.pathname + window.location.search);\n      var parentLi = $(this).parent();\n\n      if (parentLi.is(\".eael-highlight-parent.eael-highlight-active\")) {\n        window.location.hash = target;\n        return false;\n      }\n\n      $(\".eael-highlight-active, .eael-highlight-parent\").removeClass(\"eael-highlight-active eael-highlight-parent\");\n      $(this).closest(\".eael-first-child\").addClass(\"eael-highlight-parent\");\n      $(this).parent().addClass(\"eael-highlight-active\");\n      window.location.hash = target;\n    }); //some site not working with **window.onscroll**\n\n    window.addEventListener(\"scroll\", function (e) {\n      eaelTocSticky();\n    });\n    var stickyScroll = $(\"#eael-toc\").data(\"stickyscroll\");\n    /**\n     * Check selector in array\n     *\n     * @param arr\n     * @param el\n     * @returns boolean\n     */\n\n    function eaelTocExclude(excludes, el) {\n      return $(el).closest(excludes).length;\n    }\n    /**\n     * check sticky\n     */\n\n\n    function eaelTocSticky() {\n      var eaelToc = document.getElementById(\"eael-toc\");\n\n      if (!eaelToc) {\n        return;\n      }\n\n      stickyScroll = stickyScroll !== undefined ? stickyScroll : 200;\n\n      if (window.pageYOffset >= stickyScroll && !eaelToc.classList.contains(\"eael-toc-disable\")) {\n        eaelToc.classList.add(\"eael-sticky\");\n      } else {\n        eaelToc.classList.remove(\"eael-sticky\");\n      }\n    }\n    /**\n     *\n     * @param content\n     * @returns {string}\n     */\n\n\n    function eael_build_id(showTitle, title) {\n      if (showTitle == \"true\" && title != \"\") {\n        //create slug from Heading text\n        return title.toString().toLowerCase().normalize(\"NFD\").trim().replace(/[^a-z0-9 -]/g, \"\").replace(/\\s+/g, \"-\").replace(/^-+/, \"\").replace(/-+$/, \"\").replace(/-+/g, \"-\");\n      } else {\n        return \"eael-table-of-content\";\n      }\n    }\n    /**\n     *\n     * @returns {null|selector}\n     */\n\n\n    function eael_toc_check_content() {\n      var eaelToc = document.getElementById(\"eael-toc\");\n\n      if (eaelToc && eaelToc.dataset.contentselector) {\n        return eaelToc.dataset.contentselector;\n      }\n\n      var contentSelectro = \".site-content\";\n\n      if ($(\".site-content\")[0]) {\n        contentSelectro = \".site-content\";\n      } else if ($(\".elementor-inner\")[0]) {\n        contentSelectro = \".elementor-inner\";\n      } else if ($(\"#site-content\")[0]) {\n        contentSelectro = \"#site-content\";\n      } else if ($(\".site-main\")) {\n        contentSelectro = \".site-main\";\n      }\n\n      return contentSelectro;\n    } //toc auto collapse\n\n\n    $(\"body\").click(function (e) {\n      var target = $(e.target);\n      var eaToc = $(\"#eael-toc\");\n\n      if (eaToc.hasClass(\"eael-toc-auto-collapse\") && eaToc.hasClass(\"eael-sticky\") && !eaToc.hasClass(\"collapsed\") && $(target).closest(\"#eael-toc\").length === 0) {\n        eaToc.toggleClass(\"collapsed\");\n      }\n    });\n    $(document).on(\"click\", \".eael-toc-close ,.eael-toc-button\", function (event) {\n      event.stopPropagation();\n      $(\".eael-toc\").toggleClass(\"collapsed\");\n    });\n\n    function eael_build_toc($settings) {\n      var pageSetting = $settings.settings,\n          title = pageSetting.eael_ext_toc_title,\n          toc_style_class = \"eael-toc-list eael-toc-list-\" + pageSetting.eael_ext_table_of_content_list_style,\n          icon = pageSetting.eael_ext_table_of_content_header_icon.value,\n          el_class = pageSetting.eael_ext_toc_position === \"right\" ? \" eael-toc-right\" : \" \";\n      toc_style_class += pageSetting.eael_ext_toc_collapse_sub_heading === \"yes\" ? \" eael-toc-collapse\" : \" \";\n      toc_style_class += pageSetting.eael_ext_toc_list_icon === \"number\" ? \" eael-toc-number\" : \" eael-toc-bullet\";\n      return '<div id=\"eael-toc\" class=\"eael-toc eael-toc-disable ' + el_class + '\">' + '<div class=\"eael-toc-header\"><span class=\"eael-toc-close\">×</span><h2 class=\"eael-toc-title\">' + title + \"</h2></div>\" + '<div class=\"eael-toc-body\"><ul id=\"eael-toc-list\" class=\"' + toc_style_class + '\"></ul></div>' + '<button class=\"eael-toc-button\"><i class=\"' + icon + '\"></i><span>' + title + \"</span></button>\" + \"</div>\";\n    }\n\n    if (typeof ea !== 'undefined' && ea.isEditMode) {\n      elementorFrontend.hooks.addAction(\"frontend/element_ready/widget\", function ($scope, jQuery) {\n        var tocLoad = jQuery(\"#eael-toc #eael-toc-list\");\n        var TocList = tocLoad.find(\"li.eael-first-child\");\n\n        if (TocList.length < 1 && tocLoad.length >= 1) {\n          var tagList = jQuery(\"#eael-toc\").data(\"eaeltoctag\");\n\n          if (tagList) {\n            eael_toc_content(eael_toc_check_content(), tagList);\n          }\n        }\n      });\n    }\n\n    var editMode = typeof isEditMode !== 'undefined' ? isEditMode : false;\n    var intSupportTag = $(\"#eael-toc\").data(\"eaeltoctag\");\n\n    if (intSupportTag !== \"\" && !editMode) {\n      eael_toc_content(eael_toc_check_content(), intSupportTag);\n    }\n  });\n})(jQuery);\n\n//# sourceURL=webpack:///./src/js/view/table-of-content.js?");

/***/ })

/******/ });