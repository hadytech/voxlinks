(function($) {
  "use strict";
  $(document).ready(function() {
    var request;
    var searchForm = $("#betterdocs-searchform");
    var searchField = $("#betterdocs-search-field");
    var searchClose = $(".docs-search-close");

    // disable from submit on enter
    searchForm.on("keyup keypress", function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });

    // ajax load titles on keyup to searchbox
    searchField.on("keyup", function(e) {
      var inputVal = $(this).val();
      var kbSlug = $('#betterdocs-search-kbslug').val();
      var resultWrapper = $(".betterdocs-live-search");

      var resultList = $(
        ".betterdocs-live-search .betterdocs-search-result-wrap"
      );
      var searchLoader = $(".docs-search-loader");

      if (
        e.key != "a" &&
        e.keyCode != 17 &&
        e.keyCode != 91 &&
        inputVal.length >= 1
      ) {
        delay(function() {
          ajaxLoad(
            inputVal,
            kbSlug,
            resultWrapper,
            resultList,
            searchLoader,
            searchClose
          );
        }, 300);
      } else if (!inputVal.length) {
        $(".betterdocs-live-search .betterdocs-search-result-wrap").addClass(
          "hideArrow"
        );
        $(".betterdocs-live-search .docs-search-result").slideUp(300);
        searchLoader.hide();
        searchClose.hide();
      }
    });
    searchClose.on("click", function() {
      $(this).hide();
      $(".betterdocs-live-search .betterdocs-search-result-wrap").addClass(
        "hideArrow"
      );
      $(".betterdocs-live-search .docs-search-result").slideUp(300);
      searchField.val("");
    });

    var delay = (function() {
      var timer = 0;
      return function(callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
      };
    })();

    function ajaxLoad(
      inputVal,
      kbSlug,
      resultWrapper,
      resultList,
      searchLoader,
      searchClose
    ) {
      if (request) {
        request.abort();
      }
      request = $.ajax({
        url: betterdocspublic.ajax_url,
        type: "post",
        data: {
          action: "betterdocs_get_search_result",
          search_input: inputVal,
          kb_slug: kbSlug
        },
        beforeSend: function() {
          searchLoader.show();
          searchClose.hide();
          resultList.addClass("hideArrow");
          $(".betterdocs-live-search .docs-search-result").slideUp(400);
        },
        success: function(html) {
          resultList.remove();
          searchLoader.hide();
          searchClose.show();
          resultWrapper.append(html);
        }
      });
    }

    var betterdocsToc = $(".betterdocs-toc");
    var betterdocsSidebar = $("#betterdocs-sidebar");
    if (betterdocsToc.length && betterdocsSidebar.length) {
      // create an instance of TOC
      var stickyTocContent = $(".betterdocs-toc").clone();
      $(".sticky-toc-container").append(stickyTocContent);

      // make sticky toc when sidebar-content scroll ends
      $(window).on("scroll", function() {
        var stickyToc = $(".sticky-toc-container");
        var tocHeight = $(".betterdocs-sidebar-content").outerHeight();
        var tocSidebar = document.querySelector(".betterdocs-sidebar-content");
        var tocSidebarRect = tocSidebar.getBoundingClientRect();
        var tocSidebarTop = Math.abs(tocSidebarRect.top);

        if (tocSidebarRect.top < 0 && tocHeight <= tocSidebarTop) {
          stickyToc.addClass("toc-sticky");
        } else {
          stickyToc.removeClass("toc-sticky");
        }
        if (
          $(window).scrollTop() >=
            betterdocsSidebar.offset().top +
              betterdocsSidebar.outerHeight() -
              window.innerHeight &&
          !betterdocsSidebar.hasClass("betterdocs-el-single-sidebar")
        ) {
          stickyToc.removeClass("toc-sticky");
        }
      });
    }

    // Add smooth scrolling to links
    $(document).on("scroll", onScroll);
    // alert(betterdocspublic.sticky_toc_offset);
    var toc_links = $(".betterdocs-toc .toc-list a");
    toc_links.on("click", function(e) {
      e.preventDefault();
      $(document).off("scroll");
      toc_links.each(function() {
        $(this).removeClass("active");
      });
      $(this).addClass("active");
      var target = this.hash,
        $target = $(target);
      var scrollTopOffset = $target.offset().top;
      $("html, body")
        .stop()
        .animate(
          { scrollTop: scrollTopOffset - betterdocspublic.sticky_toc_offset },
          "slow",
          function() {
            $(document).on("scroll", onScroll);
          }
        );
    });

    // function to add link active class on scroll
    function onScroll() {
      var scrollPos = $(document).scrollTop();
      $(
        ".sticky-toc-container .betterdocs-toc .toc-list a,.layout2-toc-container .betterdocs-toc .toc-list a"
      ).each(function() {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (
          refElement.position().top <= scrollPos &&
          refElement.position().top + refElement.height() > scrollPos
        ) {
          $(".betterdocs-toc .toc-list a").removeClass("active");
          currLink.addClass("active");
        }
      });
    }

    // close sticky toc
    $(".close-toc").on("click", function(event) {
      event.preventDefault();
      $(".sticky-toc-container").remove(".sticky-toc-container");
    });

    // close sticky toc
    $("body").on("click", ".betterdocs-print-btn", function(event) {
      let entryTitle = "";
      if ($("#betterdocs-entry-title").length) {
        entryTitle = document.getElementById("betterdocs-entry-title")
          .innerHTML;
      }

      var printContents = document.getElementById("betterdocs-single-content")
        .innerHTML;
      var combined = document.createElement("div");
      combined.innerHTML = "<h1>" + entryTitle + "</h1>" + " " + printContents;
      combined.id = "new-doc-print";
      var pwidth = document.getElementById("betterdocs-single-content")
        .offsetWidth;
      var wheight = $(window).height();
      var winPrint = window.open(
        "",
        "",
        "left=50%,top=10%,width=" +
          pwidth +
          ",height=" +
          wheight +
          ",toolbar=0,scrollbars=0,status=0"
      );
      winPrint.document.write(combined.outerHTML);
      winPrint.document.close();
      winPrint.focus();
      winPrint.print();
      winPrint.close();
    });

    // Add accordion to sidebar category grid
    var sidebarContent = $(".betterdocs-sidebar-content");
    var catList = $(
      ".betterdocs-sidebar-content .docs-single-cat-wrap .docs-item-container"
    );
    var currentCatList = $(
      ".betterdocs-sidebar-content .docs-single-cat-wrap.current-category .docs-item-container"
    );
    var catHeading = $(
      ".betterdocs-sidebar-content .docs-single-cat-wrap .docs-cat-title-wrap"
    );
    catList.hide();
    if (currentCatList.length) {
      currentCatList.show().addClass("show");
    }
    catHeading.click(function(e) {
      var $this = $(this);
      sidebarContent.find(".active-title").removeClass("active-title");
      $this.toggleClass("active-title");
      if ($this.next(catList).hasClass("show")) {
        $this
          .next(catList)
          .slideUp()
          .removeClass("show");
      } else if (catList.hasClass("show")) {
        catList.slideUp().removeClass("show");
        $this
          .next(catList)
          .slideToggle()
          .toggleClass("show");
      } else {
        $this
          .next(catList)
          .slideToggle()
          .toggleClass("show");
      }
    });

    var docSubCat = $(".docs-sub-cat-title, .el-betterdocs-grid-sub-cat-title");
    docSubCat.each(function() {
      $(this).click(function(e) {
        e.preventDefault();
        $(this)
          .children(".toggle-arrow")
          .toggle();
        $(this)
          .next(".docs-sub-cat, .docs-sub-cat-list")
          .slideToggle();
      });
    });

    var docTocTitle = $(".betterdocs-toc.collapsible-sm .toc-title");
    docTocTitle.each(function() {
      $(this).click(function(e) {
        e.preventDefault();
        $(this)
          .children(".angle-icon")
          .toggle();
        $(this)
          .next(".toc-list")
          .slideToggle();
      });
    });

    // single post feedback form modal
    var formModal = $("#betterdocs-form-modal");
    var formModalContent = $("#betterdocs-form-modal .modal-content");

    //select all the a tag with name equal to modal
    $("a[name=betterdocs-form-modal]").click(function(e) {
      e.preventDefault();
      formModal.fadeIn(500);
    });

    //if outside of modal content is clicked
    $(document).mouseup(function(e) {
      if (
        !formModalContent.is(e.target) &&
        formModalContent.has(e.target).length === 0
      ) {
        formModal.fadeOut();
      }
    });

    //if close button is clicked
    $(".betterdocs-modalwindow .close").click(function(e) {
      e.preventDefault();
      formModal.fadeOut(500);
    });

    // ajax feedback form submit
    var feedbackForm = $("#betterdocs-feedback-form");

    var feedbackFormFields = $(
      "#betterdocs-feedback-form input, #betterdocs-feedback-form textarea"
    );
    feedbackFormFields.on("keyup", function() {
      $(this).removeClass("val-error");
      $(this)
        .siblings(".error-message")
        .remove();
    });
    feedbackForm.on("submit", function(e) {
      e.preventDefault();
      var form = $(this);
      var message_name = $("#message_name");
      var message_email = $("#message_email");
      var message_subject = $("#message_subject");
      var message_text = $("#message_text");
      betterdocsFeedbackFormSubmit(
        form,
        message_name,
        message_email,
        message_subject,
        message_text
      );
    });
    function betterdocsFeedbackFormSubmit(
      form,
      message_name,
      message_email,
      message_subject,
      message_text
    ) {
      if (request) {
        request.abort();
      }
      request = $.ajax({
        url: betterdocspublic.ajax_url,
        type: "post",
        data: {
          action: "betterdocs_feedback_form_submit",
          form: form.serializeArray(),
          postID: betterdocspublic.post_id,
          message_name: message_name.val(),
          message_email: message_email.val(),
          message_subject: message_subject.val(),
          message_text: message_text.val(),
          security: betterdocspublic.nonce,
        },
        beforeSend: function() {},
        success: function(data) {
          var data = JSON.parse(data);
          if (data.sentStatus) {
            if (data.sentStatus === "success") {
              $(".response").html(
                '<span class="success-message">' + data.sentMessage + "</span>"
              );
              form[0].reset();
              delay(function() {
                $(".betterdocs-modalwindow").fadeOut(500);
                $(".response .success-message").remove();
              }, 3000);
            } else {
              $(".response").html(
                '<span class="error-message">' + data.sentMessage + "</span>"
              );
            }
          } else {
            if (data.nameStatus === "error") {
              if (message_name.hasClass("val-error") == false) {
                message_name.addClass("val-error");
                $(".form-name").append(
                  '<span class="error-message">' + data.nameMessage + "</span>"
                );
              }
            }
            if (data.emailStatus === "error") {
              if (message_email.hasClass("val-error") == false) {
                message_email.addClass("val-error");
                $(".form-email").append(
                  '<span class="error-message">' + data.emailMessage + "</span>"
                );
              }
            }
            if (data.messageStatus === "error") {
              if (message_text.hasClass("val-error") == false) {
                message_text.addClass("val-error");
                $(".form-message").append(
                  '<span class="error-message">' +
                    data.messageMessage +
                    "</span>"
                );
              }
            }
          }
        }
      });
    }

    if ($(".anchor").length) {
      // tooltips
      $(".anchor")
        .hover(
          function() {
            var title = $(this).attr("data-title");
            $("<div/>", {
              text: title,
              class: "tooltip-box"
            }).appendTo(this);
          },
          function() {
            // $(document).find("div.tooltip-box").remove();
          }
        )
        .on("click", function(e) {
          // Clipboard
          e.preventDefault();
          var a = new ClipboardJS(".anchor");
          a.on("success", function(e) {
            $(document)
              .find("div.tooltip-box")
              .text(betterdocspublic.copy_text);
            e.clearSelection(),
              $(e.trigger).addClass("copied"),
              setTimeout(function() {
                $(e.trigger).removeClass("copied");
              }, 2000);
          });
        });

      (function() {
        if (typeof self === "undefined" || !self.Prism || !self.document) {
          return;
        }

        if (!Prism.plugins.toolbar) {
          console.warn(
            "Copy to Clipboard plugin loaded before Toolbar plugin."
          );

          return;
        }

        var ClipboardJS = window.ClipboardJS || undefined;

        if (!ClipboardJS && typeof require === "function") {
          ClipboardJS = require("clipboard");
        }

        var callbacks = [];

        if (!ClipboardJS) {
          var script = document.createElement("script");
          var head = document.querySelector("head");

          script.onload = function() {
            ClipboardJS = window.ClipboardJS;

            if (ClipboardJS) {
              while (callbacks.length) {
                callbacks.pop()();
              }
            }
          };

          script.src =
            "https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js";
          head.appendChild(script);
        }

        Prism.plugins.toolbar.registerButton("copy-to-clipboard", function(
          env
        ) {
          var linkCopy = document.createElement("button");
          linkCopy.textContent = "Copy";

          if (!ClipboardJS) {
            callbacks.push(registerClipboard);
          } else {
            registerClipboard();
          }

          return linkCopy;

          function registerClipboard() {
            var clip = new ClipboardJS(linkCopy, {
              text: function() {
                return env.code;
              }
            });

            clip.on("success", function() {
              linkCopy.textContent = "Copied!";

              resetText();
            });
            clip.on("error", function() {
              linkCopy.textContent = "Press Ctrl+C to copy";

              resetText();
            });
          }

          function resetText() {
            setTimeout(function() {
              linkCopy.textContent = "Copy";
            }, 5000);
          }
        });
      })();
    }
  });
})(jQuery);
