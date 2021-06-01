var BetterDocs = function ($scope, $) {
    let masonryGrid = $(".betterdocs-category-grid.masonry",$scope);
    let columnPerGrid = $(".betterdocs-category-grid.masonry",$scope).attr('data-column');
    let masonryItem = $(".betterdocs-category-grid.masonry .el-betterdocs-category-grid-post",$scope);
    let column_space = $(".betterdocs-category-grid.masonry",$scope).attr('data-column-space');
    let total_margin = columnPerGrid * column_space;
    if (masonryGrid.length) {
        masonryItem.css("width", "calc((100% - "+total_margin+"px) / "+parseInt(columnPerGrid)+")");
        masonryGrid.masonry({
            itemSelector: ".el-betterdocs-category-grid-post",
            percentPosition: true,
            gutter: parseInt(column_space)
        });
    }
};
jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/betterdocs-category-grid.default", BetterDocs);
});
