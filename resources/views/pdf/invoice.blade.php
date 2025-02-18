<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Laralink" />
    <!-- Site Title -->
    <title>General Purpose Invoice</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            position: relative;
        }

        .invoice-top {
            background-color: #fff;
            height: 200px;
            background-image: url('bg-img/shape1.png');
            background-repeat: no-repeat;
            position: relative;
        }

        .invoice-title {
            text-transform: uppercase;
            font-size: 50px;
            line-height: 1rem;
            color: #000;
            font-family: normal;
            float: right;
            margin-top: 5px;
            font-family: 'Inter', sans-serif;
        }

        .invoice-top .right {
            float: right;
            margin-top: 55px;
        }

        .invoice-top .left {
            position: absolute;
            top: 25px;
            left: 30px;
        }

        .arrow-css {
            width: 40%;
            height: 8%;
            position: absolute;
            bottom: 20px;
            left: 10px;
        }

        .invoice-number {
            background: whitesmoke;
            padding: 12px 35px;
            margin-top: 26%;
            border-radius: 66px 0px 0px 0px;
            /* margin-right: 35px; */
        }

        .invoice-date {
            margin-left: 10px;
            color: #666;
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50px;
        }

        .address-part {
            /* width: 500px; */
            background-color: #fff !important;
        }

        .address-part .address-left {
            /* width: 50px; */
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: #666;
            margin-left: 10px;
        }

        .address-part .address-right {
            /* width: 50px; */
            text-align: right;
            font-family: "Inter", sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: #666;
            margin-right: 10px;
            margin-top: -140px;
        }












        details {
            display: block;
        }

        /*
 * Add the correct display in all browsers.
 */
        summary {
            display: list-item;
        }

        /* Misc
   ========================================================================== */
        /**
 * Add the correct display in IE 10+.
 */
        template {
            display: none;
        }

        /**
 * Add the correct display in IE 10.
 */
        [hidden] {
            display: none;
        }

        /*--------------------------------------------------------------
2. Typography
----------------------------------------------------------------*/
        body,
        html {
            color: #666;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 400;
            line-height: 1em;
            overflow-x: hidden;
            background-color: #f5f6fa;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            clear: both;
            color: #111;
            padding: 0;
            margin: 0 0 20px 0;
            font-weight: 500;
            line-height: 1.2em;
        }

        h1 {
            font-size: 60px;
        }

        h2 {
            font-size: 48px;
        }

        h3 {
            font-size: 30px;
        }

        h4 {
            font-size: 24px;
        }

        h5 {
            font-size: 18px;
        }

        h6 {
            font-size: 16px;
        }

        p,
        div {
            margin-top: 0;
            line-height: 1.5em;
        }

        p {
            margin-bottom: 15px;
        }

        ul {
            margin: 0 0 25px 0;
            padding-left: 20px;
            list-style: disc;
        }

        ol {
            padding-left: 20px;
            margin-bottom: 25px;
        }

        dfn,
        cite,
        em,
        i {
            font-style: italic;
        }

        blockquote {
            margin: 0 15px;
            font-style: italic;
            font-size: 20px;
            line-height: 1.6em;
            margin: 0;
        }

        address {
            margin: 0 0 15px;
        }

        img {
            border: 0;
            max-width: 100%;
            height: auto;
            vertical-align: middle;
        }

        a {
            color: inherit;
            text-decoration: none;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        a:hover {
            color: #007aff;
        }

        button {
            color: inherit;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        a:hover {
            text-decoration: none;
            color: inherit;
        }

        table {
            width: 100%;
            caption-side: bottom;
            border-collapse: collapse;
        }

        th {
            text-align: left;
        }

        td {
            border-top: 1px solid #dbdfea;
        }

        td {
            padding: 10px 15px;
            line-height: 1em;
        }

        th {
            padding: 10px 15px;
            line-height: 1em;
        }

        dl {
            margin-bottom: 25px;
        }

        dl dt {
            font-weight: 600;
        }

        b,
        strong {
            font-weight: bold;
        }

        pre {
            color: #666;
            border: 1px solid #dbdfea;
            font-size: 18px;
            padding: 25px;
            border-radius: 5px;
        }

        kbd {
            font-size: 100%;
            background-color: #666;
            border-radius: 5px;
        }

        a:hover {
            color: #007aff;
        }

        ul {
            padding-left: 15px;
        }

        /*--------------------------------------------------------------
3. Invoice General Style
----------------------------------------------------------------*/
        .tm_f10 {
            font-size: 10px;
        }

        .tm_f11 {
            font-size: 11px;
        }

        .tm_f12 {
            font-size: 12px;
        }

        .tm_f13 {
            font-size: 13px;
        }

        .tm_f14 {
            font-size: 14px;
        }

        .tm_f15 {
            font-size: 15px;
        }

        .tm_f16 {
            font-size: 16px;
        }

        .tm_f17 {
            font-size: 17px;
        }

        .tm_f18 {
            font-size: 18px;
        }

        .tm_f19 {
            font-size: 19px;
        }

        .tm_f20 {
            font-size: 20px;
        }

        .tm_f21 {
            font-size: 21px;
        }

        .tm_f22 {
            font-size: 22px;
        }

        .tm_f23 {
            font-size: 23px;
        }

        .tm_f24 {
            font-size: 24px;
        }

        .tm_f25 {
            font-size: 25px;
        }

        .tm_f26 {
            font-size: 26px;
        }

        .tm_f27 {
            font-size: 27px;
        }

        .tm_f28 {
            font-size: 28px;
        }

        .tm_f29 {
            font-size: 29px;
        }

        .tm_f30 {
            font-size: 30px;
        }

        .tm_f40 {
            font-size: 40px;
        }

        .tm_f50 {
            font-size: 50px;
        }

        .tm_light {
            font-weight: 300;
        }

        .tm_normal {
            font-weight: 400;
        }

        .tm_medium {
            font-weight: 500;
        }

        .tm_semi_bold {
            font-weight: 600;
        }

        .tm_bold {
            font-weight: 700;
        }

        .tm_m0 {
            margin: 0px;
        }

        .tm_mb0 {
            margin-bottom: 0px;
        }

        .tm_mb1 {
            margin-bottom: 1px;
        }

        .tm_mb2 {
            margin-bottom: 2px;
        }

        .tm_mb3 {
            margin-bottom: 3px;
        }

        .tm_mb4 {
            margin-bottom: 4px;
        }

        .tm_mb5 {
            margin-bottom: 5px;
        }

        .tm_mb6 {
            margin-bottom: 6px;
        }

        .tm_mb7 {
            margin-bottom: 7px;
        }

        .tm_mb8 {
            margin-bottom: 8px;
        }

        .tm_mb9 {
            margin-bottom: 9px;
        }

        .tm_mb10 {
            margin-bottom: 10px;
        }

        .tm_mb11 {
            margin-bottom: 11px;
        }

        .tm_mb12 {
            margin-bottom: 12px;
        }

        .tm_mb13 {
            margin-bottom: 13px;
        }

        .tm_mb14 {
            margin-bottom: 14px;
        }

        .tm_mb15 {
            margin-bottom: 15px;
        }

        .tm_mb16 {
            margin-bottom: 16px;
        }

        .tm_mb17 {
            margin-bottom: 17px;
        }

        .tm_mb18 {
            margin-bottom: 18px;
        }

        .tm_mb19 {
            margin-bottom: 19px;
        }

        .tm_mb20 {
            margin-bottom: 20px;
        }

        .tm_mb21 {
            margin-bottom: 21px;
        }

        .tm_mb22 {
            margin-bottom: 22px;
        }

        .tm_mb23 {
            margin-bottom: 23px;
        }

        .tm_mb24 {
            margin-bottom: 24px;
        }

        .tm_mb25 {
            margin-bottom: 25px;
        }

        .tm_mb26 {
            margin-bottom: 26px;
        }

        .tm_mb27 {
            margin-bottom: 27px;
        }

        .tm_mb28 {
            margin-bottom: 28px;
        }

        .tm_mb29 {
            margin-bottom: 29px;
        }

        .tm_mb30 {
            margin-bottom: 30px;
        }

        .tm_mb40 {
            margin-bottom: 40px;
        }

        .tm_pt25 {
            padding-top: 25px;
        }

        .tm_pt0 {
            padding-top: 0;
        }

        .tm_radius_6_0_0_6 {
            border-radius: 6px 0 0 6px;
        }

        .tm_radius_0_6_6_0 {
            border-radius: 0 6px 6px 0;
        }

        .tm_radius_0 {
            border-radius: 0 !important;
        }

        .tm_width_1 {
            width: 8.33333333%;
        }

        .tm_width_2 {
            width: 16.66666667%;
        }

        .tm_width_3 {
            width: 25%;
        }

        .tm_width_4 {
            width: 33.33333333%;
        }

        .tm_width_5 {
            width: 41.66666667%;
        }

        .tm_width_6 {
            width: 50%;
        }

        .tm_width_7 {
            width: 58.33333333%;
        }

        .tm_width_8 {
            width: 66.66666667%;
        }

        .tm_width_9 {
            width: 75%;
        }

        .tm_width_10 {
            width: 83.33333333%;
        }

        .tm_width_11 {
            width: 91.66666667%;
        }

        .tm_width_12 {
            width: 100%;
        }

        .tm_border {
            border: 1px solid #dbdfea;
        }

        .tm_border_bottom {
            border-bottom: 1px solid #dbdfea;
        }

        .tm_border_top {
            border-top: 1px solid #dbdfea;
        }

        .tm_border_left {
            border-left: 1px solid #dbdfea;
        }

        .tm_border_right {
            border-right: 1px solid #dbdfea;
        }

        .tm_round_border {
            border: 1px solid #dbdfea;
            overflow: hidden;
            border-radius: 6px;
        }

        .tm_accent_color,
        .tm_accent_color_hover:hover {
            color: #007aff;
        }

        .tm_accent_bg,
        .tm_accent_bg_hover:hover {
            background-color: #007aff;
        }

        .tm_accent_bg_10 {
            background-color: rgba(0, 122, 255, 0.1);
        }

        .tm_accent_bg_20 {
            background-color: rgba(0, 122, 255, 0.15);
        }

        .tm_green_bg {
            background-color: #34c759;
        }

        .tm_green_bg_15 {
            background-color: rgba(52, 199, 89, 0.1);
        }

        .tm_primary_bg,
        .tm_primary_bg_hover:hover {
            background-color: #111;
        }

        .tm_primary_bg_2 {
            background-color: #000036;
        }

        .tm_danger_color {
            color: red;
        }

        .tm_primary_color {
            color: #111;
        }

        .tm_secondary_color {
            color: #666;
        }

        .tm_ternary_color {
            color: #b5b5b5;
        }

        .tm_white_color {
            color: #fff;
        }

        .tm_white_color_60 {
            color: rgba(255, 255, 255, 0.6);
        }

        .tm_gray_bg {
            background: #f5f6fa;
        }

        .tm_ternary_bg {
            background-color: #b5b5b5;
        }

        .tm_accent_10_bg {
            background-color: rgba(0, 122, 255, 0.1);
        }

        .tm_accent_border {
            border-color: #007aff;
        }

        .tm_accent_border_10 {
            border-color: rgba(0, 122, 255, 0.1);
        }

        .tm_accent_border_20 {
            border-color: rgba(0, 122, 255, 0.2);
        }

        .tm_accent_border_30 {
            border-color: rgba(0, 122, 255, 0.3);
        }

        .tm_accent_border_40 {
            border-color: rgba(0, 122, 255, 0.4);
        }

        .tm_accent_border_50 {
            border-color: rgba(0, 122, 255, 0.5);
        }

        .tm_primary_border {
            border-color: #111;
        }

        .tm_gray_border {
            border-color: #f5f6fa;
        }

        .tm_primary_border_2 {
            border-color: #000036;
        }

        .tm_secondary_border {
            border-color: #666;
        }

        .tm_ternary_border {
            border-color: #b5b5b5;
        }

        .tm_border_color {
            border-color: #dbdfea;
        }

        .tm_border_1 {
            border-style: solid;
            border-width: 1px;
        }

        .tm_body_lineheight {
            line-height: 1.5em;
        }

        .tm_invoice_in {
            position: relative;
            z-index: 100;
        }

        .tm_container {
            max-width: 880px;
            padding: 30px 15px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .tm_text_center {
            text-align: center;
        }

        .tm_text_uppercase {
            text-transform: uppercase;
        }

        .tm_text_right {
            text-align: right;
        }

        .tm_align_center {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .tm_border_bottom_0 {
            border-bottom: 0;
        }

        .tm_border_top_0 {
            border-top: 0;
        }

        .tm_table_baseline {
            vertical-align: baseline;
        }

        .tm_border_none {
            border: none !important;
        }

        .tm_flex {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .tm_justify_between {
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .tm__align_center {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
        }

        .tm_border_left_none {
            border-left-width: 0;
        }

        .tm_border_right_none {
            border-right-width: 0;
        }

        .tm_table_responsive {
            overflow-x: auto;
        }

        .tm_table_responsive>table {
            min-width: 600px;
        }

        .tm_50_col>* {
            width: 50%;
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
        }

        .tm_no_border {
            border: none !important;
        }

        .tm_grid_row {
            display: -ms-grid;
            display: grid;
            grid-gap: 10px 20px;
            list-style: none;
            padding: 0;
        }

        .tm_col_2 {
            -ms-grid-columns: (1fr)[2];
            grid-template-columns: repeat(2, 1fr);
        }

        .tm_col_3 {
            -ms-grid-columns: (1fr)[3];
            grid-template-columns: repeat(3, 1fr);
        }

        .tm_col_4 {
            -ms-grid-columns: (1fr)[4];
            grid-template-columns: repeat(4, 1fr);
        }

        .tm_max_w_150 {
            max-width: 150px;
        }

        .tm_left_auto {
            margin-left: auto;
        }

        hr {
            background: #dbdfea;
            height: 1px;
            border: none;
            margin: 0;
        }

        .tm_invoice {
            background: #fff;
            border-radius: 10px;
            padding: 50px;
        }

        .tm_invoice_footer {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .tm_invoice_footer table {
            margin-top: -1px;
        }

        .tm_invoice_footer .tm_left_footer {
            /* width: 58%; */
            padding: 10px 15px;
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
        }

        .tm_invoice_footer .tm_right_footer {
            /* width: 42%; */
        }

        .tm_note {
            margin-top: 30px;
            font-style: italic;
        }

        .tm_font_style_normal {
            font-style: normal;
        }

        .tm_sign img {
            max-height: 45px;
        }

        .tm_coffee_shop_img {
            position: absolute;
            height: 200px;
            opacity: 0.04;
            top: 40px;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
        }

        .tm_coffee_shop_img img {
            max-height: 100%;
        }

        .tm_invoice.tm_style1 .tm_invoice_right {
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
            width: 60%;
        }

        .tm_invoice.tm_style1 .tm_invoice_table {
            grid-gap: 1px;
        }

        .tm_invoice.tm_style1 .tm_invoice_table>* {
            border: 1px solid #dbdfea;
            margin: -1px;
            padding: 8px 15px 10px;
        }

        .tm_invoice.tm_style1 .tm_invoice_head {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .tm_invoice.tm_style1 .tm_invoice_head .tm_invoice_right div {
            line-height: 1em;
        }

        .tm_invoice.tm_style1 .tm_invoice_info {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .tm_invoice.tm_style1 .tm_invoice_info_2 {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            border-top: 1px solid #dbdfea;
            border-bottom: 1px solid #dbdfea;
            padding: 11px 0;
        }

        .tm_invoice.tm_style1 .tm_invoice_seperator {
            min-height: 18px;
            border-radius: 1.6em;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin-right: 20px;
        }

        .tm_invoice.tm_style1 .tm_invoice_info_list {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .tm_invoice.tm_style1 .tm_invoice_info_list>*:not(:last-child) {
            margin-right: 20px;
        }

        .tm_invoice.tm_style1 .tm_logo img {
            max-height: 50px;
        }

        .tm_invoice.tm_style1 .tm_logo.tm_size1 img {
            max-height: 60px;
        }

        .tm_invoice.tm_style1 .tm_logo.tm_size2 img {
            max-height: 70px;
        }

        .tm_invoice.tm_style1 .tm_grand_total {
            padding: 8px 15px;
        }

        .tm_invoice.tm_style1 .tm_box_3 {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .tm_invoice.tm_style1 .tm_box_3>* {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }

        .tm_invoice.tm_style1 .tm_box_3 ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tm_invoice.tm_style1 .tm_box_3 ul li {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .tm_invoice.tm_style1 .tm_box_3 ul li:not(:last-child) {
            margin-bottom: 5px;
        }

        .tm_invoice.tm_style1 .tm_box_3 ul span {
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
        }

        .tm_invoice.tm_style1 .tm_box_3 ul span:first-child {
            margin-right: 5px;
        }

        .tm_invoice.tm_style1 .tm_box_3 ul span:last-child {
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }

        .tm_invoice.tm_style2 .tm_invoice_head {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border-bottom: 1px solid #dbdfea;
            padding-bottom: 15px;
            position: relative;
        }

        .tm_invoice.tm_style2 .tm_invoice_left {
            width: 30%;
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
        }

        .tm_invoice.tm_style2 .tm_invoice_right {
            width: 70%;
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
        }

        .tm_invoice.tm_style2 .tm_invoice_info {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .tm_invoice.tm_style2 .tm_invoice_info_left {
            width: 30%;
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
        }

        .tm_invoice.tm_style2 .tm_invoice_info_right {
            width: 70%;
            -webkit-box-flex: 0;
            -ms-flex: none;
            flex: none;
        }

        .tm_invoice.tm_style2 .tm_logo img {
            max-height: 60px;
        }

        .tm_invoice.tm_style2 .tm_invoice_title {
            line-height: 0.8em;
        }

        .tm_invoice.tm_style2 .tm_invoice_info_in {
            padding: 12px 20px;
            border-radius: 10px;
        }

        .tm_invoice.tm_style2 .tm_card_note {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 6px;
            margin-bottom: 10px;
            margin-top: 5px;
        }

        .tm_invoice.tm_style2 .tm_invoice_footer .tm_left_footer {
            padding-left: 0;
        }

        .tm_invoice.tm_style1.tm_type1 {
            padding: 0px 50px 30px;
            position: relative;
            overflow: hidden;
            border-radius: 0;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_head {
            height: 110px;
            position: relative;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_shape_bg {
            position: absolute;
            height: 100%;
            width: 70%;
            -webkit-transform: skewX(35deg);
            transform: skewX(35deg);
            top: 0px;
            right: -100px;
            overflow: hidden;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_shape_bg img {
            height: 100%;
            width: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            -webkit-transform: skewX(-35deg) translateX(-45px);
            transform: skewX(-35deg) translateX(-45px);
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_right {
            position: relative;
            z-index: 2;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_logo img {
            max-height: 70px;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_seperator {
            margin-right: 0;
            border-radius: 0;
            -webkit-transform: skewX(35deg);
            transform: skewX(35deg);
            position: absolute;
            height: 100%;
            width: 57.5%;
            right: -60px;
            overflow: hidden;
            border: none;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_seperator img {
            height: 100%;
            width: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            -webkit-transform: skewX(-35deg);
            transform: skewX(-35deg);
            -webkit-transform: skewX(-35deg) translateX(-10px);
            transform: skewX(-35deg) translateX(-10px);
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_info {
            position: relative;
            padding: 4px 0;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_card_note,
        .tm_invoice.tm_style1.tm_type1 .tm_invoice_info_list {
            position: relative;
            z-index: 1;
        }

        .tm_invoice.tm_style1.tm_type2 {
            position: relative;
            overflow: hidden;
            border-radius: 0;
        }

        .tm_invoice.tm_style1.tm_type2 td {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_pt0 {
            padding-top: 0;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_bars {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            position: absolute;
            top: 0px;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            overflow: hidden;
            padding: 0 15px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_bars span {
            height: 100px;
            width: 5px;
            display: block;
            margin: -15px 20px 0;
            -webkit-transform: rotate(-40deg);
            transform: rotate(-40deg);
        }

        .tm_invoice.tm_style1.tm_type2 .tm_bars.tm_type1 {
            top: initial;
            bottom: 0;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_bars.tm_type1 span {
            margin: 0 20px 0;
            position: relative;
            bottom: -15px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape {
            height: 230px;
            width: 250px;
            position: absolute;
            top: 0;
            right: 0;
            overflow: hidden;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape .tm_shape_in {
            position: absolute;
            height: 350px;
            width: 350px;
            -webkit-transform: rotate(40deg);
            transform: rotate(40deg);
            top: -199px;
            left: 67px;
            overflow: hidden;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape.tm_type1 {
            top: initial;
            bottom: 0;
            right: initial;
            left: 0;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape.tm_type1 .tm_shape_in {
            top: 135px;
            left: -153px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape_2 {
            height: 120px;
            width: 120px;
            border: 5px solid currentColor;
            padding: 20px;
            position: absolute;
            bottom: -30px;
            right: 77px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape_2 .tm_shape_2_in {
            height: 100%;
            width: 100%;
            border: 20px solid currentColor;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape_2.tm_type1 {
            left: -76px;
            right: initial;
            bottom: 245px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape_2.tm_type1 .tm_shape_2_in {
            border-width: 6px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_invoice_right {
            width: 40%;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_logo img {
            max-height: 65px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_invoice_footer {
            margin-bottom: 120px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_right_footer {
            position: relative;
            padding: 6px 0;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_right_footer table {
            position: relative;
            z-index: 2;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_left_footer {
            padding: 30px 15px;
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape_3 {
            position: absolute;
            top: 0;
            left: -40px;
            height: 100%;
            width: calc(100% + 150px);
            -webkit-transform: skewX(35deg);
            transform: skewX(35deg);
        }

        .tm_invoice.tm_style1.tm_type2 .tm_shape_4 {
            position: absolute;
            bottom: 200px;
            left: 0;
            height: 200px;
            width: 200px;
        }

        .tm_invoice.tm_style1.tm_type3 {
            position: relative;
            overflow: hidden;
            border-radius: 0;
        }

        .tm_invoice.tm_style1.tm_type3 .tm_shape_1 {
            position: absolute;
            top: -1px;
            left: 0;
        }

        .tm_invoice.tm_style1.tm_type3 .tm_shape_2 {
            position: absolute;
            bottom: 0;
            left: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .tm_invoice.tm_style1.tm_type3 .tm_logo img {
            max-height: 60px;
        }

        .tm_invoice.tm_style1.tm_type3 .tm_invoice_head.tm_mb20 {
            margin-bottom: 65px;
        }

        .tm_invoice.tm_style1.tm_type3 .tm_invoice_info_list {
            position: relative;
            padding: 10px 0 10px 40px;
        }

        .tm_invoice.tm_style1.tm_type3 .tm_invoice_info_list_bg {
            position: absolute;
            height: 100%;
            width: calc(100% + 100px);
            top: 0;
            left: 0;
            border-radius: 20px 0 0 0px;
            -webkit-transform: skewX(-35deg);
            transform: skewX(-35deg);
        }

        .tm_invoice.tm_style2.tm_type1 {
            padding-top: 0;
            padding-bottom: 0;
            border-width: 40px 0 0;
            border-style: solid;
            position: relative;
            overflow: hidden;
        }

        .tm_invoice.tm_style2.tm_type1.tm_small_border {
            border-width: 7px 0 0;
        }

        .tm_invoice.tm_style2.tm_type1 .tm_shape_bg {
            position: absolute;
            height: 100%;
            width: 42%;
            -webkit-transform: skewX(-35deg);
            transform: skewX(-35deg);
            top: 0px;
            left: -100px;
        }

        .tm_invoice.tm_style2.tm_type1 .tm_invoice_head {
            padding-top: 15px;
            border-bottom: none;
        }

        .tm_invoice.tm_style2.tm_type1 .tm_logo {
            position: relative;
            z-index: 2;
        }

        .tm_invoice.tm_style2.tm_type1 .tm_bottom_invoice {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding: 15px 50px 20px;
            border-top: 1px solid #dbdfea;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            margin: 30px -50px 0;
        }

        .tm_invoice_content {
            position: relative;
            z-index: 10;
        }

        .tm_invoice_wrap {
            position: relative;
        }

        .tm_note_list li:not(:last-child) {
            margin-bottom: 5px;
        }

        .tm_list.tm_style1 {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tm_list.tm_style1 svg {
            width: 16px;
            height: initial;
        }

        .tm_list.tm_style1 .tm_list_icon {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            position: absolute;
            left: 0;
            top: 3px;
        }

        .tm_list.tm_style1 li {
            padding-left: 25px;
            position: relative;
        }

        .tm_list.tm_style1 li:not(:last-child) {
            margin-bottom: 5px;
        }

        .tm_list.tm_style1.tm_text_right li {
            padding-left: 0;
            padding-right: 25px;
        }

        .tm_list.tm_style1.tm_text_right .tm_list_icon {
            left: initial;
            right: 0;
        }

        .tm_section_heading {
            border-width: 0 0 1px 0;
            border-style: solid;
        }

        .tm_section_heading>span {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 7px 7px 0 0;
        }

        .tm_section_heading .tm_curve_35 {
            margin-left: 12px;
            margin-right: 0;
        }

        .tm_section_heading .tm_curve_35 span {
            display: inline-block;
        }

        .tm_padd_15_20 {
            padding: 15px 20px;
        }

        .tm_padd_8_20 {
            padding: 8px 20px;
        }

        .tm_padd_20 {
            padding: 20px;
        }

        .tm_padd_15 {
            padding: 15px;
        }

        .tm_padd_10 {
            padding: 10px;
        }

        .tm_padd_5 {
            padding: 5px;
        }

        .tm_curve_35 {
            -webkit-transform: skewX(-35deg);
            transform: skewX(-35deg);
            padding: 12px 20px 12px 30px;
            margin-left: 22px;
            margin-right: 22px;
        }

        .tm_curve_35>* {
            -webkit-transform: skewX(35deg);
            transform: skewX(35deg);
        }

        .tm_dark_invoice_body {
            background-color: #18191a;
        }

        .tm_dark_invoice {
            background: #252526;
            color: rgba(255, 255, 255, 0.65);
        }

        .tm_dark_invoice .tm_primary_color {
            color: rgba(255, 255, 255, 0.9);
        }

        .tm_dark_invoice .tm_secondary_color {
            color: rgba(255, 255, 255, 0.65);
        }

        .tm_dark_invoice .tm_ternary_color {
            color: rgba(255, 255, 255, 0.4);
        }

        .tm_dark_invoice .tm_gray_bg {
            background: rgba(255, 255, 255, 0.08);
        }

        .tm_dark_invoice .tm_border_color,
        .tm_dark_invoice .tm_round_border,
        .tm_dark_invoice td,
        .tm_dark_invoice th,
        .tm_dark_invoice .tm_border_top,
        .tm_dark_invoice .tm_border_bottom {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .tm_dark_invoice+.tm_invoice_btns {
            background: #252526;
            border-color: #252526;
        }

        .tm_invoice_btns {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            margin-top: 0px;
            margin-left: 20px;
            position: absolute;
            left: 100%;
            top: 0;
            -webkit-box-shadow: -2px 0 24px -2px rgba(43, 55, 72, 0.05);
            box-shadow: -2px 0 24px -2px rgba(43, 55, 72, 0.05);
            border: 3px solid #fff;
            border-radius: 6px;
            background-color: #fff;
        }

        .tm_invoice_btn {
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border: none;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            background-color: transparent;
            position: relative;
        }

        .tm_invoice_btn svg {
            width: 24px;
        }

        .tm_invoice_btn .tm_btn_icon {
            padding: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: 42px;
            width: 42px;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .tm_invoice_btn .tm_btn_text {
            position: absolute;
            left: 100%;
            background-color: #111;
            color: #fff;
            padding: 3px 12px;
            display: inline-block;
            margin-left: 10px;
            border-radius: 5px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            font-weight: 500;
            min-height: 28px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
        }

        .tm_invoice_btn .tm_btn_text:before {
            content: '';
            height: 10px;
            width: 10px;
            position: absolute;
            background-color: #111;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            left: -3px;
            top: 50%;
            margin-top: -6px;
            border-radius: 2px;
        }

        .tm_invoice_btn:hover .tm_btn_text {
            opacity: 1;
            visibility: visible;
        }

        .tm_invoice_btn:not(:last-child) {
            margin-bottom: 3px;
        }

        .tm_invoice_btn.tm_color1 {
            background-color: rgba(0, 122, 255, 0.1);
            color: #007aff;
            border-radius: 5px 5px 0 0;
        }

        .tm_invoice_btn.tm_color1:hover {
            background-color: rgba(0, 122, 255, 0.2);
        }

        .tm_invoice_btn.tm_color2 {
            background-color: rgba(52, 199, 89, 0.1);
            color: #34c759;
            border-radius: 0 0 5px 5px;
        }

        .tm_invoice_btn.tm_color2:hover {
            background-color: rgba(52, 199, 89, 0.2);
        }

        .tm_invoice_btns {
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            margin-top: 0px;
            margin-top: 20px;
            -webkit-box-shadow: -2px 0 24px -2px rgba(43, 55, 72, 0.05);
            box-shadow: -2px 0 24px -2px rgba(43, 55, 72, 0.05);
            border: 3px solid #fff;
            border-radius: 6px;
            background-color: #fff;
            position: relative;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
        }

        .tm_invoice_btn {
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border: none;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            background-color: transparent;
            position: relative;
            border-radius: 5px;
            padding: 6px 15px;
        }

        .tm_invoice_btn svg {
            width: 24px;
        }

        .tm_invoice_btn .tm_btn_icon {
            padding: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            margin-right: 8px;
        }

        .tm_invoice_btn:not(:last-child) {
            margin-right: 3px;
        }

        .tm_invoice_btn.tm_color1 {
            background-color: rgba(0, 122, 255, 0.1);
            color: #007aff;
        }

        .tm_invoice_btn.tm_color1:hover {
            background-color: rgba(0, 122, 255, 0.2);
        }

        .tm_invoice_btn.tm_color2 {
            background-color: rgba(52, 199, 89, 0.1);
            color: #34c759;
        }

        .tm_invoice_btn.tm_color2:hover {
            background-color: rgba(52, 199, 89, 0.2);
        }

        .tm_col_4 {
            -ms-grid-columns: (1fr)[1];
            grid-template-columns: repeat(1, 1fr);
        }

        .tm_col_2_md {
            -ms-grid-columns: (1fr)[2];
            grid-template-columns: repeat(2, 1fr);
        }

        .tm_m0_md {
            margin: 0;
        }

        .tm_mb10_md {
            margin-bottom: 10px;
        }

        .tm_mb15_md {
            margin-bottom: 15px;
        }

        .tm_mb20_md {
            margin-bottom: 20px;
        }

        .tm_mobile_hide {
            display: none;
        }

        .tm_invoice {
            padding: 30px 20px;
        }

        .tm_invoice .tm_right_footer {
            width: 100%;
        }

        .tm_invoice_footer {
            -webkit-box-orient: vertical;
            -webkit-box-direction: reverse;
            -ms-flex-direction: column-reverse;
            flex-direction: column-reverse;
            z-index: 99999999;
        }

        .tm_invoice_footer .tm_left_footer {
            width: 100%;
            border-top: 1px solid #dbdfea;
            margin-top: -1px;
            padding: 15px 0;
        }

        .tm_invoice.tm_style2 .tm_card_note {
            margin-top: 0;
        }

        .tm_note.tm_text_center {
            text-align: left;
        }

        .tm_note.tm_text_center p br {
            display: none;
        }

        .tm_invoice_footer.tm_type1 {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .tm_invoice.tm_style2 .tm_invoice_head {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .tm_invoice.tm_style2 .tm_invoice_head>* {
            width: 100%;
        }

        .tm_invoice.tm_style2 .tm_invoice_head .tm_invoice_left {
            margin-bottom: 15px;
        }

        .tm_invoice.tm_style2 .tm_invoice_head .tm_text_right {
            text-align: left;
        }

        .tm_invoice.tm_style2 .tm_invoice_info {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .tm_invoice.tm_style2 .tm_invoice_info>* {
            width: 100%;
        }

        .tm_invoice.tm_style1.tm_type1 {
            padding: 30px 20px;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_head {
            height: initial;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_info {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            padding-left: 15px;
            padding-right: 15px;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_seperator {
            width: 100%;
            -webkit-transform: initial;
            transform: initial;
            right: 0;
            top: 0;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_logo img {
            max-height: 60px;
        }

        .tm_invoice.tm_style2.tm_type1 {
            border-width: 20px 0 0;
        }

        .tm_invoice.tm_style2.tm_type1 .tm_shape_bg {
            width: 250px;
            height: 80px;
        }

        .tm_invoice.tm_style2.tm_type1 .tm_invoice_head .tm_text_center {
            text-align: left;
        }

        .tm_invoice.tm_style2.tm_type1 .tm_logo {
            top: -8px;
            margin-bottom: 15px;
        }

        .tm_invoice.tm_style2 .tm_invoice_info_in {
            padding: 12px 15px;
        }

        .tm_border_none_md {
            border: none !important;
        }

        .tm_border_left_none_md {
            border-left-width: 0;
        }

        .tm_border_right_none_md {
            border-right-width: 0;
        }

        .tm_padd_left_15_md {
            padding-left: 15px !important;
        }

        .tm_invoice.tm_style2 .tm_logo img {
            max-height: 50px;
        }

        .tm_curve_35 {
            -webkit-transform: skewX(0deg);
            transform: skewX(0deg);
            margin-left: 0;
            margin-right: 0;
        }

        .tm_curve_35>* {
            -webkit-transform: inherit;
            transform: inherit;
        }

        .tm_invoice.tm_style1.tm_type1 .tm_invoice_seperator,
        .tm_invoice.tm_style1.tm_type1 .tm_invoice_seperator img {
            -webkit-transform: initial;
            transform: initial;
        }

        .tm_section_heading .tm_curve_35 {
            margin-left: 0;
        }

        .tm_shape_2.tm_type1 {
            display: none;
        }
        .footer-shape2{
            position: relative;
            bottom: 0px;
        }
        .footer-shape2-content{
            background-color: #fff;
            height: 200px;
            background-image: url('bg-img/shape2.png');
            background-repeat: no-repeat;
            position: relative;
            top: 0px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-top">
            <div class="left">
                @if($company->name)
                <img src="{{ $company->media_url }}" class="logo" alt="LOGO">
                @else
                <img src="{{url('bg-img/logo.jpg')}}" class="logo" alt="LOGO">
                @endif
            </div>
            <div class="right">
                <span class="invoice-title">Invoice</span>
                <div class="invoice-number">
                    <span style="color: #666;">Invoice No: <strong style="color: #000;">{{$invoice->invoice_code}}</strong></span>
                    <span class="invoice-date">Date: <strong style="color: #000;">{{ dDate($invoice->invoice_date) }}</strong></span>
                </div>
            </div>
            <img src="{{url('bg-img/arrow_bg.svg')}}" class="arrow-css" alt="">
        </div>

        <div class="address-part">
            <div class="address-left">
                <p class=""><b style="color: #111">Invoice To:</b></p>
                <p style="line-height: 1.5rem; margin-top: -10px">
                    @if($invoice->customer)
                        @if($invoice->customer->name)
                        <span>{{ $invoice->customer->name }}</span> <br />
                        @endif
                        @if($invoice->customer->phone)
                        <span>{{ $invoice->customer->phone }}</span> <br />
                        @endif
                        @if($invoice->customer->email)
                        <span>{{ $invoice->customer->email }}</span> <br />
                        @endif
                        @if($invoice->customer->address)
                        <span>{{ $invoice->customer->address }}</span>
                        @endif
                    @endif
                </p>
            </div>
            <div class="address-right">
                <p class=""><b style="color: #111">Pay To:</b></p>
                <p style="line-height: 1.5rem; margin-top: -10px">

                    @if($company->name)
                    <span>{{ $company->name }}</span> <br />
                    @endif

                    @if($company->phone2)
                    <span>{{ $company->phone }}, {{ $company->phone2 }}</span> <br />
                    @else
                    <span>{{ $company->phone }}<br />
                    @endif

                    @if($company->address)
                    <span>{{ $company->address }}</span> <br />
                    @endif

                    @if($company->email)
                    <span>{{ $company->email }}</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="tm_table tm_style1 tm_mb30">
            <div class="tm_table_responsive">
                <table class="tm_border_bottom">
                    <thead>
                        <tr class="tm_border_top">
                            <th class="tm_width_3 tm_semi_bold tm_primary_color tm_accent_bg_10">Product Type</th>
                            <th class="tm_width_4 tm_semi_bold tm_primary_color tm_accent_bg_10">Category</th>
                            <th class="tm_width_2 tm_semi_bold tm_primary_color tm_accent_bg_10">Color</th>
                            <th class="tm_width_1 tm_semi_bold tm_primary_color tm_accent_bg_10">Unit price</th>
                            <th class="tm_width_2 tm_semi_bold tm_primary_color tm_accent_bg_10 tm_text_right">Quantity</th>
                            <th class="tm_width_2 tm_semi_bold tm_primary_color tm_accent_bg_10 tm_text_right">Amount</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #fff !important;">
                    @foreach($invoice->details as $key => $item)
                        <tr>
                            <td class="tm_width_2">{{ $item->product_type }}</td>
                            <td class="tm_width_2">{{ $item->category }}</td>
                            <td class="tm_width_2">{{ $item->color }}</td>
                            <td class="tm_width_2 tm_text_right">{{ $item->price }}</td>
                            <td class="tm_width_2">{{ $item->quantity }} {{ $item->unit }}</td>
                            <td class="tm_width_2 tm_text_right">{{ $item->amount }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tm_invoice_footer" style="background-color: #fff;">

                <div class="tm_right_footer">
                    <table>
                        <tbody>
                            <tr>
                                <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Sub-Total</td>
                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">{{ $invoice->sub_total }}</td>
                            </tr>
                            <tr>
                                <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Discount <span class="tm_ternary_color">({{ $invoice->discount_percentage }}%)</span></td>
                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">{{ $invoice->discount_amount }}</td>
                            </tr>
                            {{-- <tr>
                                <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Tax <span class="tm_ternary_color">({{ $invoice->tax_percentage }}%)</span></td>
                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">{{ $invoice->tax_amount }}</td>
                            </tr>
                            <tr>
                                <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Vat <span class="tm_ternary_color">({{ $invoice->vat_percentage }}%)</span></td>
                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">{{ $invoice->vat_amount }}</td>
                            </tr> --}}
                            <tr class="tm_border_top tm_border_bottom">
                                <td class="tm_width_3 tm_border_top_0 tm_bold tm_primary_color">Total Payable Amount</td>
                                <td class="tm_width_3 tm_border_top_0 tm_bold tm_primary_color tm_text_right">{{ $invoice->total_payable_amount }}</td>
                            </tr>
                            <tr style="padding-top: 10px">
                                <td class="tm_width_3 tm_primary_color tm_border_none">Paid Amount</td>
                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none">{{ $invoice->paid_amount }}</td>
                            </tr>

                            @if($invoice->due_amount)
                            <tr>
                                <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Due Amount</td>
                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">{{ $invoice->due_amount }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0 tm_bold">Payment Status</td>
                                <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0 tm_bold">{{ $invoice->payment_status->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- <div class="tm_left_footer">
                    <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                    <p class="tm_m0">Credit Card - 236***********928 <br>Amount: $1732</p>
                </div> --}}
            </div>
        </div>
        <div class="footer-shape2">
            <div class="footer-shape2-content" style="background-color: #fff;">
                <p class="tm_mb2" style="top: 30px;position:absolute;"><b class="tm_primary_color">Terms & Conditions:</b></p>
                <ul class="tm_m0 tm_note_list" style="top: 50px;position:absolute;">
                    <li>If you buy one time, you cannot return your products.</li>
                    <li>But If you want to change any product then it can be negotiable.</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
