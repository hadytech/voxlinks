(function ($) {
	$(window).on('elementor/frontend/init', function () {
		var isEditMode = false;
		if (elementorFrontend.isEditMode()) {
			isEditMode = true;
		}
		if (isEditMode) {
			parent.document.addEventListener("mousedown", function (e) {
				var widgets = parent.document.querySelectorAll(".elementor-element--promotion");
				if (widgets.length > 0) {
					for (var i = 0; i < widgets.length; i++) {
						if (widgets[i].contains(e.target)) {
							var dialog = parent.document.querySelector("#elementor-element--promotion__dialog");
							var icon   = widgets[i].querySelector(".icon > i");

							if (icon.classList.toString().indexOf("betterdocs-icon") >= 0) {
								var dialogSelector = dialog.querySelectorAll(".dialog-buttons-action");
								if (dialogSelector.length > 0) {
									for (var i = 0; i < dialogSelector.length; i++) {
										dialogSelector[i].style.display = "none";
									}
								}
								e.stopImmediatePropagation();
								if (dialog.querySelector(".betterdocs-dialog-buttons-action") === null) {
									var button     = document.createElement("a");
									var buttonText = document.createTextNode("Upgrade BetterDocs");

									button.setAttribute("href", "https://betterdocs.co/upgrade");
									button.setAttribute("target", "_blank");
									button.classList.add(
										"dialog-button",
										"dialog-action",
										"dialog-buttons-action",
										"elementor-button",
										"elementor-button-success",
										"betterdocs-dialog-buttons-action"
									);
									button.appendChild(buttonText);

									dialog.querySelector(".dialog-buttons-action").insertAdjacentHTML("afterend", button.outerHTML);
								} else {
									dialog.querySelector(".betterdocs-dialog-buttons-action").style.display = "";
								}
							} else {
								dialog.querySelector(".dialog-buttons-action").style.display = "";

								if (dialog.querySelector(".betterdocs-dialog-buttons-action") !== null) {
									dialog.querySelector(".betterdocs-dialog-buttons-action").style.display = "none";
								}
							}
							// stop loop
							break;
						}
					}
				}
			});
		}
	});
}(jQuery));

