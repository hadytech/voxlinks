<?php
    $average = $value['average'];
    $top5Products = $value['top_5_product'];
    $top5Reviewers = $value['top_5_reviewer'];
?>
<div class="rx_insightAvgWrap">
    <div class="rx_insightAvgWrap__avg">
        <h1 class="rx_insightAvgWrap__avg__title">
            <?php echo ($average['avg_rating']); ?>
        </h1>
        <div class="rx_insightAvgWrap__avg__star">
            <span>
                <?php foreach ($average['star'] as $item): ?>
                    <?php if($item): ?>
                        <svg style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path style="fill: #ff8853" fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>
                    <?php else : ?>
                        <svg style="width: 18px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path style="fill: #ffd1bd" fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>
                    <?php endif; ?>
                <?php endforeach; ?>
            </span>
        </div>
        <p class="rx_insightAvgWrap__avg__count"><?php esc_html_e('based on', 'reviewx'); ?> <?php echo esc_html( $average['total_review'] ); ?> <?php esc_html_e('ratings', 'reviewx'); ?></p>
    </div>
    <div class="rx_insightAvgWrap__progress">
        <?php foreach ($average['percentage'] as $key => $item): ?>
            <div class="rx_insightAvgWrap__progress__summery">
                <div class="rx_insightAvgWrap__progress__summery__left">
                    <span><?php echo esc_html( $key ); ?></span>
                </div>
                <div class="rx_insightAvgWrap__progress__summery__center">
                    <div class="rx_insightAvgWrap__progress__summery__center__progressBar">
                        <div style="width: <?php echo ($item); ?>%" class="rx_insightAvgWrap__progress__summery__center__progressBar__fill"></div>
                    </div>
                </div>
                <div class="rx_insightAvgWrap__progress__summery__right">
                    <span><?php echo esc_html( $item ); ?>%</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<!--<div class="rx_productPieChart">-->
<!--    <div class="rx_productPieChart__block rx_productPieChart__block_margin">-->
<!--        <div class="rx_productPieChart__block__header">-->
<!--            <h1 class="rx_productPieChart__block__header__title">Product</h1>-->
<!--        </div>-->
<!--        <div class="rx_productPieChart__block__content">-->
<!--            <table>-->
<!--                <tbody>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                            <div id="chartContainer" style="height: 140px; width: 140px; margin: 0px auto;"></div>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                        <table class="rx_productPieChart__block__content__chartInfo">-->
<!--                            <tbody>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #172290;"></span>Product</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">30%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #004fff;"></span>Price</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">25%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #00b0ff;"></span>Delivery</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">15%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #0fd499;"></span>Service</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">7%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #f6e131;"></span>Overall</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">10%</td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="rx_productPieChart__block">-->
<!--        <div class="rx_productPieChart__block__header">-->
<!--            <h1 class="rx_productPieChart__block__header__title">Price</h1>-->
<!--        </div>-->
<!--        <div class="rx_productPieChart__block__content">-->
<!--            <table>-->
<!--                <tbody>-->
<!--                    <tr>-->
<!--                        <td>-->
<!--                        <div id="chartContainer2" style="height: 140px; width: 140px; margin: 0px auto;"></div>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                        <table class="rx_productPieChart__block__content__chartInfo">-->
<!--                            <tbody>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #172290;"></span>Product</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">30%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #004fff;"></span>Price</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">25%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #00b0ff;"></span>Delivery</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">15%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #0fd499;"></span>Service</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">7%</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__title"><span style="background-color: #f6e131;"></span>Overall</td>-->
<!--                                    <td class="rx_productPieChart__block__content__chartInfo__value">10%</td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->

<div class="rx_topProductReview">
    <div class="rx_topProductReview__block rx_topProductReview__block_margin">
        <div class="rx_topProductReview__block__bar">
            <h1 class="rx_topProductReview__block__bar__title"><?php esc_html_e('Top Product by Review', 'reviewx' ); ?></h1>
            <!-- <select class="rx_topProductReview__block__bar__option">
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select> -->
        </div>
        <?php foreach ($top5Products as $key => $product): ?>
            <div class="rx_topProductReview__block__content">
                <h1 class="rx_topProductReview__block__content__title"><?php esc_html_e($key+1, 'reviewx'); ?>. <?php echo esc_html( $product->details->post_name ); ?></h1>
                <h3 class="rx_topProductReview__block__content__subTitle"><?php esc_html_e($product->rating, 'reviewx'); ?> <?php esc_html_e('average rating', 'reviewx'); ?></h3>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="rx_topProductReview__block">
        <div class="rx_topProductReview__block__bar">
            <h1 class="rx_topProductReview__block__bar__title"><?php esc_html_e('Top Customars by Review', 'reviewx'); ?></h1>
            <!-- <select class="rx_topProductReview__block__bar__option">
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
            </select> -->
        </div>
        <?php foreach ($top5Reviewers as $key => $reviewer): ?>
            <div class="rx_topProductReview__block__content">
                <h1 class="rx_topProductReview__block__content__title"><?php echo esc_html($key+1 ); ?>. <?php echo esc_html($reviewer->name ); ?></h1>
                <h3 class="rx_topProductReview__block__content__subTitle"><?php esc_html_e('Total Review', 'reviewx'); ?> <?php echo esc_html( $reviewer->total_review ); ?></h3>
            </div>
        <?php endforeach; ?>
    </div>
    
</div>

<script>
    // window.onload = function () {
    // var chart = new CanvasJS.Chart("chartContainer", {
    //     animationEnabled: true,
    //     title:{
    //         text: "Email Categories",
    //         horizontalAlign: "left"
    //     },
    //     data: [{
    //         type: "doughnut",
    //         startAngle: 60,
    //         //innerRadius: 60,
    //         indexLabelFontSize: 15,
    //         //indexLabel: "{label} - #percent%",
    //         toolTipContent: " {y} (#percent%)",
    //         dataPoints: [
    //             { y: 30, label: "" },
    //             { y: 25, label: "" },
    //             { y: 15, label: "" },
    //             { y: 7, label: ""},
    //             { y: 10, label: ""},
    //         ]
    //     }]
    // });
    // chart.render();
    // chart.title.remove();

    // //
    // var chart2 = new CanvasJS.Chart("chartContainer2", {
    //     animationEnabled: true,
    //     title:{
    //         text: "Email Categories",
    //         horizontalAlign: "left"
    //     },
    //     data: [{
    //         type: "doughnut",
    //         startAngle: 60,
    //         //innerRadius: 60,
    //         indexLabelFontSize: 15,
    //         //indexLabel: "{label} - #percent%",
    //         toolTipContent: " {y} (#percent%)",
    //         dataPoints: [
    //             { y: 30, label: "" },
    //             { y: 25, label: "" },
    //             { y: 15, label: "" },
    //             { y: 7, label: ""},
    //             { y: 10, label: ""},
    //         ]
    //     }]
    // });
    // chart2.render();
    // chart2.title.remove();

    // }
</script>