@extends('layouts.transporter.dashboard.app')

@section('head_css')
    <style>
        .adjust-space-without-btn {
            margin-bottom: 40px !important;
        }

        .jobsrch_info_list h6 {
            width: 10% !important;
        }

        .vehicle_image {
            width: 500px !important;
        }

        a.make_offer_btn {
            margin-top: 30px;
        }

        .jobsrch_top_box img {
            object-fit: cover;
            height: 272px !important;
        }

        .jobsrch_info_list li:nth-last-child(1) {
            margin-bottom: 0;
        }

        .distance_text {
            margin-bottom: 25px;
        }

        h4.distance_text strong {
            color: #898989;
        }

        .jobsrch_info_list li small {
            font-size: 15px;
            margin-left: 10px;
        }

        .jpbsrch_inner {
            width: 50%;
        }

        .jobsrch_info_list span {
            width: 50%;
        }

        .jobsrch_info_list li {
            margin-bottom: 37px;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }


        /* .jobsrch_form_blog .form-control {
                                        color: #000000;
                                    } */
        .jobsrch_form_blog .error-message {
            position: absolute;
            bottom: -34px;
            padding-left: 0;
        }



        .custom-navigation {
            position: absolute;
            bottom: 14px;
            left: 15px;
            color: #fff;
            font-size: 15px;
        }

        .jobsrch_top_box .slick-prev {
            left: 10px;
        }

        .jobsrch_top_box .slick-next {
            right: 10px;
        }

        .jobsrch_top_box .slick-next,
        .jobsrch_top_box .slick-prev {
            z-index: 1;
        }

        .jobsrch_top_box .slick-next:before,
        .jobsrch_top_box .slick-prev:before {
            font-size: 0;
            display: block;
        }

        .jobsrch_top_box .slick-arrow.slick-disabled svg {
            display: none;
        }


        .bid_form input.form-control {
            height: auto;
            font-size: 20px;
        }

        .bid_form span.icon_includes {
            height: 62px;
        }

        .bid_form span#amount-error,
        .bid_form span#message-error {
            padding: 0;
        }

        .bid_form .form-group {
            position: relative;
        }

        .bid_form textarea.form-control.textarea {
            height: 107px;
        }

        .get_quote .modal-content {
            padding: 20px 30px;
            /* margin:0px 10px; */
        }

        .get_quote .modal-header span svg {
            margin-right: 0px;
            width: 17px;
            height: 17px;
        }

        /* .get_quote .modal-header .close {
                                position: absolute;
                                right: 15px;
                            } */

        /* Add your CSS styling here */
        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            text-align: center;
            width: 350px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1;
            box-shadow: 0px 4px 4px 0px #00000040;
            border-radius: 8px;
        }

        #popup.show {
            display: block;
        }

        #popup img {
            width: 100%;
            margin: 20px 0;
        }

        #popup p {
            font-size: 20px;
            font-weight: 500;
        }

        .modal_current {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 7px;
        }

        .modal_current p {
            margin: 0;
            font-weight: normal;
            font-size: 13px;
            color: #000000d6;
        }

        .modal_current p span {
            color: #52D017;
        }

        .modal_current p span.red {
            color: #0356D6;
        }

        .modal-footer button.submit_btn {
            text-transform: none;
        }

        .submit_btn {
            padding: 8px 60px !important;
            margin: 0 auto 5px;
            font-size: 19px;
        }

        .page-item:last-child .page-link,
        .page-item:first-child .page-link {
            padding-bottom: 6px;
            padding-left: 3px;
            font-size: 20px;
        }




        /* start 16-09-2024 */

        .jobserch_mob li span.sub_color {
            margin-left: 4px;
        }

        .job-data {
            margin-left: 0px;
            margin-bottom: 0px;
        }

        .job-data span {
            color: #9C9C9C;
            font-size: 15px;
        }

        /* #carDetailsModal .modal-header button.btn-close {
                                position: absolute;
                                top: 11px;
                                right: 15px;
                            } */

        #carDetailsModal .modal-header span {
            display: flex;
            align-items: center;
            color: #9C9C9C;
            font-size: 18px;
        }

        #carDetailsModal .modal-header {
            border-bottom: 0;
            padding-bottom: 0;
        }

        #carDetailsModal .modal-header span svg {
            margin-right: 7px;
        }

        #carDetailsModal .modal-header button.btn-close {
            background: transparent;
            border: none;
            font-size: 22px;
            color: #9C9C9C;
            padding: 0;
            margin-left: auto;
            line-height: 18px;
        }

        #carDetailsModal .jobsrch_box {
            padding: 0;
            background: transparent;
            border-radius: 0;
            border: none;
            box-shadow: none;
            margin-bottom: 0;
        }

        #carDetailsModal .jobsrch_box .col-lg-6 {
            flex: auto;
            max-width: 100%;
        }

        #carDetailsModal .jobsrch_box img.vehicle_image {
            height: 250px !important;
        }

        #carDetailsModal .modal-dialog {
            max-width: 500px;
        }

        #carDetailsModal h4.distance_text {
            margin-bottom: 20px;
            text-align: left;
            font-size: 16px;
        }

        #carDetailsModal .jobsrch_right_box {
            margin-top: 20px;
        }

        #carDetailsModal ul.jobsrch_info_list li {
            margin-bottom: 20px;
        }

        #carDetailsModal ul.jobsrch_info_list li svg {
            width: 24px;
        }

        .jobserch_mob li svg {
            margin-bottom: 7px;
            width: 22px;
            height: 22px;
        }

        .job_new_grid_bid_btn.pop_new_btn a.make_offer_btn {
            color: #fff !important;
            background: #52D017 !important;
        }

        .jobserch_mob li p {
            font-size: 15px;
            font-weight: 300;
            letter-spacing: 0em;
            color: #000;
            text-align: left;
            margin-bottom: 5px;
            display: block !important;
        }

        small.new_tag {
            position: absolute;
            background: #52d017;
            color: #fff;
            right: -48px;
            padding: 3px 32px;
            font-size: 13px;
            transform: rotate(50deg);
            top: -11px;
        }

        .jobserch_mob .jobsrch_box {
            overflow: hidden;
        }

        small.expring_tag {
            position: absolute;
            background: #ED1C24;
            color: #fff;
            right: -54px;
            padding: 3px 32px;
            font-size: 12px;
            transform: rotate(50deg);
            top: -8px;
        }

        .content_container {
            padding: 95px 0 0px;
        }

        #page-content-wrapper {
            padding-bottom: 20px;
        }

        .get_quote.avoid-user-to-place-bid .modal-header {
            margin-bottom: 0;
        }

        .get_quote.avoid-user-to-place-bid .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 4px 0rgba(0, 0, 0, 0.25);
            padding: 35px;
        }

        .get_quote.avoid-user-to-place-bid .modal-title {
            font-size: 20px;
            line-height: 25px;
            font-weight: 400;
        }

        .get_quote.avoid-user-to-place-bid .modal-body {
            font-size: 12px;
            line-height: 15px;
            font-weight: 300;
            color: #444444;
            text-align: center;
            margin: 25px 0;
        }

        .get_quote.avoid-user-to-place-bid .modal-dialog {
            max-width: 285px;
        }

        .get_quote.avoid-user-to-place-bid .modal-footer {
            margin-top: 0;
        }

        .get_quote.avoid-user-to-place-bid .modal-footer button {
            font-size: 14px;
            line-height: 18px;
            font-weight: 400 !important;
            margin-bottom: 0;
            border-radius: 5px;
        }

        @media (min-width: 579px) {

            .jobserch_mob .jobsrch_box {
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .jobserch_mob .jobsrch_box .row {
                margin: 0;
            }

            .jobserch_mob .jobsrch_box ul.jobsrch_info_list {
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                column-gap: 15px;
                position: relative;
                padding-top: 18px;
                row-gap: 0px;
            }

            .jobserch_mob li p {
                display: none;
            }

            .jobserch_mob .job_new_grid_img {
                width: 16%;
                margin-bottom: 15px;
            }

            .jobserch_mob .job_new_grid_post_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_vehi_modal {
                width: 20%;
            }

            .jobserch_mob li {
                display: block;
                margin-bottom: 0;
                align-items: center;
            }

            .jobserch_mob li span {
                display: block;
                font-weight: 400;
            }

            .jobserch_mob .job_new_grid_drop_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_time_from {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_date {
                width: 30%;
                display: flex;
                position: absolute;
                top: -7px;
                left: 0;
            }

            .jobserch_mob .job_new_grid_date span {
                font-size: 12px;
                color: #000000ba;
            }

            .jobserch_mob .job_new_grid_img img {
                height: auto !important;
                border-radius: 5px;
            }

            .jobserch_mob .job_new_grid_img span {
                display: block;
                color: #9C9C9C;
                width: 100%;
                font-size: 8px;
            }

            .jobserch_mob .job_new_grid_lowest {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_type {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_bidding {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_miles {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_lowest span,
            .jobserch_mob .job_new_grid_type span,
            .jobserch_mob .job_new_grid_bidding span,
            .jobserch_mob .job_new_grid_miles span {
                font-size: 14px;
                font-weight: 300;
                color: #000000b8;
            }

            .jobserch_mob li span.sub_color {
                display: flex;
            }

            .jobserch_mob .job_new_grid_date span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_lowest span {
                width: max-content;
            }

            .jobserch_mob li span.sub_color {
                color: #52d017;
            }

            .jobserch_mob .job_new_grid_type span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_bidding span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_miles span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_type .sub_color {
                color: #0356D6;
            }

            .jobserch_mob .job_new_grid_bidding span.sub_color {
                color: #0356D6;
            }

            .job_new_grid_bid_btn.pop_new_btn {
                position: inherit;
                top: 6px;
                right: 0;
                width: max-content;
                margin-left: auto;
                display: block;
            }

            .jobserch_mob_grid.new_job_design {
                position: relative;
            }

            .job_new_grid_bid_btn.pop_new_btn a.make_offer_btn {
                margin: 0;
                padding: 6px 15px;
                font-size: 12px;
                border-radius: 7px;
                white-space: nowrap;
            }

            .jobserch_mob .job_new_grid_vehi_modal span {
                width: 100%;
            }


        }

        @media (min-width: 768px) {

            .jobserch_mob .jobsrch_box {
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .jobserch_mob .jobsrch_box .row {
                margin: 0;
            }

            .jobserch_mob .jobsrch_box ul.jobsrch_info_list {
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                column-gap: 15px;
                position: relative;
                padding-top: 18px;
                row-gap: 0px;
            }

            .jobserch_mob .job_new_grid_img {
                width: 13%;
                margin-bottom: 15px;
            }

            .jobserch_mob .job_new_grid_post_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_vehi_modal {
                width: 20%;
            }

            .jobserch_mob li {
                display: block;
                margin-bottom: 0;
                align-items: center;
            }

            .jobserch_mob li span {
                display: block;
                font-weight: 400;
            }

            .jobserch_mob .job_new_grid_drop_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_time_from {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_date {
                width: 30%;
                display: flex;
                position: absolute;
                top: -7px;
                left: 0;
            }

            .jobserch_mob .job_new_grid_date span {
                font-size: 12px;
                color: #000000ba;
            }

            .jobserch_mob .job_new_grid_img img {
                height: auto !important;
                border-radius: 5px;
            }

            .jobserch_mob .job_new_grid_img span {
                display: block;
                color: #9C9C9C;
                width: 100%;
                font-size: 8px;
            }

            .jobserch_mob .job_new_grid_lowest {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_type {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_bidding {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_miles {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_lowest span,
            .jobserch_mob .job_new_grid_type span,
            .jobserch_mob .job_new_grid_bidding span,
            .jobserch_mob .job_new_grid_miles span {
                font-size: 14px;
                font-weight: 300;
                color: #000000b8;
            }

            .jobserch_mob li span.sub_color {
                display: flex;
            }

            .jobserch_mob .job_new_grid_date span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_lowest span {
                width: max-content;
            }

            .jobserch_mob li span.sub_color {
                color: #52d017;
            }

            .jobserch_mob .job_new_grid_type span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_bidding span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_miles span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_type .sub_color {
                color: #0356D6;
            }

            .jobserch_mob .job_new_grid_bidding span.sub_color {
                color: #0356D6;
            }

            .job_new_grid_bid_btn.pop_new_btn {
                position: absolute;
                top: 16%;
                right: 0;
            }

            .jobserch_mob_grid.new_job_design {
                position: relative;
            }

            .job_new_grid_bid_btn.pop_new_btn a.make_offer_btn {
                margin: 0;
                padding: 6px 15px;
                font-size: 12px;
                border-radius: 7px;
                white-space: nowrap;
            }

            .jobserch_mob .job_new_grid_vehi_modal span {
                width: 100%;
            }

            .jobserch_mob li p {
                display: none !important;
            }





        }

        @media screen and (min-width: 1000px) and (max-width: 1199px) {

            .jobserch_mob .jobsrch_box {
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .jobserch_mob .jobsrch_box .row {
                margin: 0;
            }

            .jobserch_mob .jobsrch_box ul.jobsrch_info_list {
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                column-gap: 15px;
                position: relative;
                padding-top: 18px;
                row-gap: 0px;
            }

            .jobserch_mob .job_new_grid_img {
                width: 13%;
                margin-bottom: 15px;
            }

            .jobserch_mob .job_new_grid_post_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_vehi_modal {
                width: 20%;
            }

            .jobserch_mob li {
                display: block;
                margin-bottom: 0;
                align-items: center;
            }

            .jobserch_mob li span {
                display: block;
                font-weight: 400;
            }

            .jobserch_mob .job_new_grid_drop_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_time_from {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_date {
                width: 30%;
                display: flex;
                position: absolute;
                top: -7px;
                left: 0;
            }

            .jobserch_mob .job_new_grid_date span {
                font-size: 12px;
                color: #000000ba;
            }

            .jobserch_mob .job_new_grid_img img {
                height: auto !important;
                border-radius: 5px;
            }

            .jobserch_mob .job_new_grid_img span {
                display: block;
                color: #9C9C9C;
                width: 100%;
                font-size: 8px;
            }

            .jobserch_mob .job_new_grid_lowest {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_type {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_bidding {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_miles {
                width: 48%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_lowest span,
            .jobserch_mob .job_new_grid_type span,
            .jobserch_mob .job_new_grid_bidding span,
            .jobserch_mob .job_new_grid_miles span {
                font-size: 14px;
                font-weight: 300;
                color: #000000b8;
            }

            .jobserch_mob li span.sub_color {
                display: flex;
            }

            .jobserch_mob .job_new_grid_date span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_lowest span {
                width: max-content;
            }

            .jobserch_mob li span.sub_color {
                color: #52d017;
            }

            .jobserch_mob .job_new_grid_type span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_bidding span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_miles span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_type .sub_color {
                color: #0356D6;
            }

            .jobserch_mob .job_new_grid_bidding span.sub_color {
                color: #0356D6;
            }

            .job_new_grid_bid_btn.pop_new_btn {
                position: absolute;
                top: 16%;
                right: 0;
            }

            .jobserch_mob_grid.new_job_design {
                position: relative;
            }

            .job_new_grid_bid_btn.pop_new_btn a.make_offer_btn {
                margin: 0;
                padding: 6px 15px;
                font-size: 12px;
                border-radius: 7px;
                white-space: nowrap;
            }

            .jobserch_mob .job_new_grid_vehi_modal span {
                width: 100%;
            }





        }

        @media(min-width: 1366px) {
            .jobserch_mob .jobsrch_box {
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .jobserch_mob .jobsrch_box .row {
                margin: 0;
            }

            .jobserch_mob .jobsrch_box ul.jobsrch_info_list {
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                column-gap: 20px;
                position: relative;
                padding-top: 20px;
                row-gap: 10px;
            }

            .jobserch_mob .job_new_grid_img {
                width: 13%;
            }

            .jobserch_mob .job_new_grid_post_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_vehi_modal {
                width: 20%;
            }

            .jobserch_mob li {
                display: block;
                margin-bottom: 0;
                align-items: center;
            }

            .jobserch_mob li span {
                display: block;
                font-weight: 400;
            }

            .jobserch_mob .job_new_grid_drop_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_time_from {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_date {
                width: 19%;
                display: flex;
                position: absolute;
                top: -7px;
                left: 0;
            }

            .jobserch_mob .job_new_grid_date span {
                font-size: 12px;
                color: #000000ba;
            }

            .jobserch_mob .job_new_grid_img img {
                height: auto !important;
                border-radius: 5px;
            }

            .jobserch_mob .job_new_grid_img span {
                display: block;
                color: #9C9C9C;
                width: 100%;
                font-size: 11px;
            }

            .jobserch_mob .job_new_grid_lowest {
                width: 20%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_type {
                width: 22%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_bidding {
                width: 20%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_miles {
                width: 29%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_lowest span,
            .jobserch_mob .job_new_grid_type span,
            .jobserch_mob .job_new_grid_bidding span,
            .jobserch_mob .job_new_grid_miles span {
                font-size: 14px;
                font-weight: 300;
                color: #000000b8;
            }

            .jobserch_mob li span.sub_color {
                display: flex;
            }

            .jobserch_mob .job_new_grid_date span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_lowest span {
                width: max-content;
            }

            .jobserch_mob li span.sub_color {
                color: #52d017;
            }

            .jobserch_mob .job_new_grid_type span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_bidding span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_miles span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_type .sub_color {
                color: #0356D6;
            }

            .jobserch_mob .job_new_grid_bidding span.sub_color {
                color: #0356D6;
            }

            .job_new_grid_bid_btn.pop_new_btn {
                position: absolute;
                top: 16%;
                right: 0;
            }

            .jobserch_mob_grid.new_job_design {
                position: relative;
            }

            .job_new_grid_bid_btn.pop_new_btn a.make_offer_btn {
                margin: 0;
                padding: 6px 15px;
                font-size: 12px;
                border-radius: 7px;
                white-space: nowrap;
            }

            .jobserch_mob .job_new_grid_vehi_modal span {
                width: 100%;
            }

            .jobserch_mob li p {
                display: block !important;
            }

        }

        @media(min-width: 1600px) {
            .jobserch_mob .jobsrch_box {
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .jobserch_mob .jobsrch_box .row {
                margin: 0;
            }

            .jobserch_mob .jobsrch_box ul.jobsrch_info_list {
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                column-gap: 20px;
                position: relative;
                padding-top: 20px;
                row-gap: 10px;
            }

            .jobserch_mob .job_new_grid_img {
                width: 10%;
            }

            .jobserch_mob .job_new_grid_post_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_vehi_modal {
                width: 20%;
            }

            .jobserch_mob li {
                display: block;
                margin-bottom: 0;
                align-items: center;
            }

            .jobserch_mob li span {
                display: block;
                font-weight: 400;
            }

            .jobserch_mob .job_new_grid_drop_code {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_time_from {
                width: 16%;
            }

            .jobserch_mob .job_new_grid_date {
                width: 19%;
                display: flex;
                position: absolute;
                top: -7px;
                left: 0;
            }

            .jobserch_mob .job_new_grid_date span {
                font-size: 12px;
                color: #000000ba;
            }

            .jobserch_mob .job_new_grid_img img {
                height: auto !important;
                border-radius: 5px;
            }

            .jobserch_mob .job_new_grid_img span {
                display: block;
                color: #9C9C9C;
                width: 100%;
                font-size: 11px;
            }

            .jobserch_mob .job_new_grid_lowest {
                width: 23%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_type {
                width: 23%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_bidding {
                width: 24%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_miles {
                width: 23%;
                display: flex;
            }

            .jobserch_mob .job_new_grid_lowest span,
            .jobserch_mob .job_new_grid_type span,
            .jobserch_mob .job_new_grid_bidding span,
            .jobserch_mob .job_new_grid_miles span {
                font-size: 14px;
                font-weight: 300;
                color: #000000b8;
            }

            .jobserch_mob li span.sub_color {
                display: flex;
            }

            .jobserch_mob .job_new_grid_date span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_lowest span {
                width: max-content;
            }

            .jobserch_mob li span.sub_color {
                color: #52d017;
            }

            .jobserch_mob .job_new_grid_type span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_bidding span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_miles span {
                width: max-content;
            }

            .jobserch_mob .job_new_grid_type .sub_color {
                color: #0356D6;
            }

            .jobserch_mob .job_new_grid_bidding span.sub_color {
                color: #0356D6;
            }

            .job_new_grid_bid_btn.pop_new_btn {
                position: absolute;
                top: 16%;
                right: 0;
            }

            .jobserch_mob_grid.new_job_design {
                position: relative;
            }

            .job_new_grid_bid_btn.pop_new_btn a.make_offer_btn {
                margin: 0;
                padding: 6px 15px;
                font-size: 12px;
                border-radius: 7px;
                white-space: nowrap;
            }

            .jobserch_mob .job_new_grid_vehi_modal span {
                width: 100%;
            }

        }

        @media(max-width: 767px) {
            .jobserch_mob li p {
                display: none !important;
            }
        }

        /* end 16-09-2024 */
        @media(max-width: 580px) {
            .jobsrch_info_list li small {
                font-size: 14px;
                margin-left: 7px;
            }

            .jobsrch_info_list span {
                font-size: 14px;
                width: 47%;
            }

            .jpbsrch_inner {
                width: 53%;
            }

            .jobsrch_info_list li {
                margin-bottom: 20px;
            }

            .jobsrch_top_box img {
                height: 203px !important;
            }

            .distance_text {
                margin-bottom: 20px;
                text-align: left;
                font-size: 16px;
            }

            .jobsrch_right_box {
                margin-top: 30px;
            }

            .modal-content {
                border-radius: 10px;
            }



            .jobserch_mob_grid {
                display: flex;
            }

            .jobserch_mob .jobsrch_top_box {
                width: 100px;
            }

            .jobserch_mob .jobsrch_top_box img {
                height: 60px !important;
                border-radius: 5px;
                width: 87px !important;
            }

            .jobserch_mob ul.jobsrch_info_list {
                margin: 0 0 0 10px;
                display: flex;
                flex-wrap: wrap;
            }

            .jobserch_mob ul.jobsrch_info_list li {
                width: 50%;
                margin: 0;
                display: flex;
                align-items: flex-start;
                line-height: normal;
            }

            .jobserch_mob .row {
                margin: 0;
            }

            .jobserch_mob {
                width: calc(100% + 60px);
                margin-left: -30px;
            }

            .jobserch_mob .jobsrch_box {
                padding: 20px;
                margin-bottom: 7px;
                border-radius: 0;
            }

            .jobserch_mob ul.jobsrch_info_list li span {
                width: 100%;
                font-size: 15px;
                display: inline;
                line-height: normal;
            }

            .jobserch_mob ul.jobsrch_info_list li svg {
                margin-right: 7px;
                width: 21px;
                display: inline-block;
            }

            .jobserch_mob .jobsrch_top_box span {
                font-size: 10px;
                color: #9C9C9C;
            }

            .modal-header {
                border-bottom: 0;
                padding-bottom: 0;
            }

            button.btn-close {
                background: transparent;
                border: none;
                font-size: 22px;
                color: #9C9C9C;
                padding: 0;
                margin-left: auto;
            }

            .modal-header span {
                display: flex;
                align-items: center;
                color: #9C9C9C;
                font-size: 18px;
            }

            .modal-header span svg {
                margin-right: 7px;
            }

            .modal-body .jobsrch_box {
                padding: 0;
                margin-bottom: 0;
                box-shadow: none;
                border-radius: 0;
            }

            .jobsrch_form_blog .form-group.field_filled,
            .jobsrch_form_blog .form-group.field_active {
                padding: 22px 24px;
                box-shadow: none;
                font-size: 18px;
                color: #000;
            }

            .jobsrch_form_blog .form-control {
                font-size: 18px;
                /* color: #000000; */
            }

            .jobsrch_form_blog .error-message {
                position: absolute;
                bottom: -24px;
                padding-left: 0;
            }



            /* .job_se_sec.slick-initialized .slick-slide {
                            display: block;
                            width: 380px !important;
                        } */

            .job_se_sec .slick-track {
                width: 760px !important;
            }

            .job_se_sec .slick-list.draggable {
                height: 203px !important;
            }

            /* .modal-header button.btn-close {
                                    position: absolute;
                                    top: 11px;
                                    right: 15px;
                                } */

            .jobserch_mob .jobsrch_box {
                padding: 20px 20px 10px;
            }



            /* 16-08-2024 */

            .new_job_design ul.jobsrch_info_list {
                margin: 0;
            }

            .new_job_design ul.jobsrch_info_list {
                margin: 0;
                display: block;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_img {
                width: 28%;
                float: left;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_post_code {
                width: 30%;
                float: left;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_vehi_modal {
                width: 41%;
                float: left;
                margin-bottom: 14px;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_drop_code {
                width: 30%;
                float: left;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_time_from {
                width: 40%;
                margin-bottom: 20px;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_miles {
                width: 59%;
                float: left;
                display: block;
                clear: both;
                padding-right: 10px;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_type {
                width: 59%;
                float: left;
                display: block;
                clear: both;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_img span {
                font-size: 10px;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_date {
                display: block;
                width: 59%;
                float: left;
                clear: both;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_lowest {
                width: 41%;
                display: block;
                float: left;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_bidding {
                width: 41%;
                display: block;
                float: left;
            }

            .jobserch_mob ul.jobsrch_info_list li span {
                font-size: 15px;
                font-weight: 400;
                width: 77%;
                line-height: 1;
            }

            .jobserch_mob ul.jobsrch_info_list li {
                margin-bottom: 6px;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_bid_btn {
                display: block;
                width: 41%;
                float: left;
                margin: 0;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_bid_btn .jobsrch_right_box {
                margin: 0;
                display: flex;
                align-items: center;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_bid_btn .jobsrch_right_box a.make_offer_btn {
                margin-top: 0;
                font-size: 15px;
                width: max-content;
                padding: 7px 33px 10px;
                border-radius: 7px;
                text-transform: none;
            }

            .jobserch_mob ul.jobsrch_info_list li span.sub_color {
                color: #0356D6 !important;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_lowest span.sub_color {
                color: #52D017 !important;
            }

            .jobserch_mob ul.jobsrch_info_list li span.sub_color span {
                color: #9C9C9C;
            }

            small.new_tag {
                position: absolute;
                background: #52d017;
                color: #fff;
                right: -50px;
                padding: 3px 32px;
                font-size: 13px;
                transform: rotate(50deg);
                top: -12px;
            }

            small.expring_tag {
                position: absolute;
                background: #ED1C24;
                color: #fff;
                right: -56px;
                padding: 3px 32px;
                font-size: 12px;
                transform: rotate(50deg);
                top: -11px;
            }

            .jobsrch_box {
                position: relative;
                overflow: hidden;
            }

            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_type span,
            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_lowest span,
            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_bidding span,
            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_date span,
            .jobserch_mob ul.jobsrch_info_list li.job_new_grid_miles span {
                color: #000000ba;
                font-size: 12px;
                font-weight: 300;
            }

            .jobserch_mob_grid.new_job_design ul.jobsrch_info_list {
                width: 100%;
            }

            .jobserch_mob_grid {
                display: flex;
                flex-wrap: wrap;
                position: relative;
                padding-bottom: 11px;
                width: 100%;
            }

            .pop_new_btn .jobsrch_right_box {
                position: absolute;
                right: 7%;
                bottom: 0;
                margin: 0;
            }

            .pop_new_btn .jobsrch_right_box a.make_offer_btn {
                font-size: 15px;
                padding: 7px 33px 10px;
                border-radius: 7px;
            }

            .jpbsrch_inner svg {
                width: 24px;
            }


            .job-data span {
                color: #9C9C9C;
                font-size: 15px;
            }

            .job-data {
                margin-left: -10px;
                margin-bottom: 8px;
            }

            .content_container {
                padding-bottom: 0;
            }

            .jobserch_mob li p {
                display: none !important;
            }


        }

        @media(max-width: 400px) {
            .jobsrch_box {
                padding: 10px;
                margin-bottom: 24px;
            }

            .pop_new_btn .jobsrch_right_box {
                right: 5%;
            }
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/globle.css') }}" />
@endsection


@section('content')
    <div id="wrapper">
        <!-- SIDEBAR -->
        @include('layouts.transporter.dashboard.sidebar')
        <div id="page-content-wrapper">
            @include('layouts.transporter.dashboard.top_head')
            <!-- content part -->
            <div class="content_container">
                <div class="banner" id="spam-banner" style="display:none">
                    <h2 class="spam-title">Check your spam.</h2>
                    <p>Please check your spam or junk folder and mark email as ‘not spam’ so that you don’t miss out on any
                        important email notifications. You can unsubscribe from job alert emails at any time within your
                        profile.</p>
                    <button onclick="hideBanner()" class="btn btn-success">Ok, got it</button>
                </div>
                <div class="job_container">
                    <div class="admin_job_bx find_trans_newjob list_of_items" id="style-1">


                        <!------------------------ 27-09-2024 start ------------------>

                        <section class="transportSection container">
                            <div class="admin_job_top" style="margin-bottom:20px!important;">
                                <h3>Find <br>transport jobs</h3>
                            </div>
                            <div class="">
                                <div id="popup">
                                    <p>Searching for transport jobs that match your criteria...</p>
                                    <img src="/uploads/loading-popup.gif" alt="Loading">
                                </div>
                                <p class="pera_srch">Search for jobs and make an offer.</p>
                                <form id="jobsrch_form_blog" class="jobsrch_form_blog">
                                    <div class="form-group where_custom">
                                        <label id="pickupLabel">Where from?</label>
                                        <input type="text" class="form-control" name="search_pick_up_area"
                                            id="search_pick_up_area" placeholder="Search collection area " />
                                        <input type="hidden" name="pick_up_latitude" id="pick_up_latitude">
                                        <input type="hidden" name="pick_up_longitude" id="pick_up_longitude">
                                        <svg class="svgvector_mob d-md-none d-block" width="22" height="22"
                                            viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2 13.4131C1.99918 7.96953 5.84383 3.28343 11.1827 2.22069C16.5215 1.15795 21.8676 4.01456 23.9514 9.04352C26.0353 14.0725 24.2764 19.8731 19.7506 22.898C15.2248 25.9228 9.19247 25.3294 5.34286 21.4806C3.20274 19.3412 2.00025 16.4392 2 13.4131Z"
                                                stroke="black" stroke-width="2.78571" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M21.4795 21.4824L27.9999 28.0028" stroke="black" stroke-width="2.78571"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="suggest_filter where_box" style="display: none;">
                                        <label>London</label>
                                        <label>Manchester</label>
                                        <label>Newcastle</label>
                                        <label>Birmingham</label>
                                        <label>Liverpool</label>
                                        <label>Essex</label>
                                        <label>Leeds</label>
                                        <label>Wales</label>
                                        <label>Sheffield</label>
                                        <label>Devon</label>
                                    </div>
                                    <div class="form-group drop_off_box">
                                        <label id="dropoffLabel">Where to?</label>
                                        <input type="text" class="form-control" name="search_drop_off_area"
                                            id="search_drop_off_area" placeholder="Anywhere" />
                                        <input type="hidden" name="drop_off_latitude" id="drop_off_latitude">
                                        <input type="hidden" name="drop_off_longitude" id="drop_off_longitude">
                                        <svg class="svgvector_mob d-md-none d-block" width="22" height="22"
                                            viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M2 13.4131C1.99918 7.96953 5.84383 3.28343 11.1827 2.22069C16.5215 1.15795 21.8676 4.01456 23.9514 9.04352C26.0353 14.0725 24.2764 19.8731 19.7506 22.898C15.2248 25.9228 9.19247 25.3294 5.34286 21.4806C3.20274 19.3412 2.00025 16.4392 2 13.4131Z"
                                                stroke="black" stroke-width="2.78571" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M21.4795 21.4824L27.9999 28.0028" stroke="black" stroke-width="2.78571"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="suggest_filter to_box" style="display: none;">
                                        <label>Anywhere</label>
                                        <label>London</label>
                                        <label>Manchester</label>
                                        <label>Newcastle</label>
                                        <label>Birmingham</label>
                                        <label>Liverpool</label>
                                        <label>Essex</label>
                                        <label>Leeds</label>
                                        <label>Wales</label>
                                        <label>Sheffield</label>
                                        <label>Devon</label>
                                    </div>


                                    <div class="form-group">
                                        <a href="javascript:;" class="srchjob_byn" id="search_job">
                                            <svg class="d-md-inline-block d-none" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="17" viewBox="0 0 16 17" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M1.21851 7.6448C1.21806 4.71363 3.28826 2.19034 6.16303 1.6181C9.0378 1.04585 11.9165 2.58403 13.0385 5.29194C14.1606 7.99984 13.2135 11.1233 10.7765 12.752C8.33955 14.3808 5.09138 14.0612 3.01851 11.9888C1.86613 10.8368 1.21864 9.27422 1.21851 7.6448Z"
                                                    stroke="#F9FFF1" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M11.7075 11.9897L15.2185 15.5007" stroke="#F9FFF1"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg><span class="d-md-inline-block d-none">Search</span> <span
                                                class="d-md-none d-inline-block">Search jobs</span>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="form-group">
                                <button type="button"  id="saveSrch" class="btn btn-success">Save
                                    Search</button>
                            </div> --}}

                            <div class="mainContentDiv">
                                <div class="job-data">
                                    @if ($quotes->total() == 0)
                                        <span>Results: 0</span>
                                    @else
                                        @if ($quotes->total() > 50)
                                            <span>Results: {{ $quotes->firstItem() }}-{{ $quotes->lastItem() }} of
                                                {{ $quotes->total() }}</span>
                                        @else
                                            @if ($quotes->firstItem() == $quotes->lastItem())
                                                <span>Results: {{ $quotes->firstItem() }} of {{ $quotes->total() }}</span>
                                            @else
                                                <span>Results: {{ $quotes->firstItem() }}-{{ $quotes->lastItem() }} of
                                                    {{ $quotes->total() }}</span>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                                <div id="orderlisting">
                                    @foreach ($quotes as $quote)
                                        <div class="boxContent addEventListener">
                                            <div class="boxContentList">

                                                <h2 class="imgHeading">
                                                    <span>Posted
                                                        {{ getTimeAgo($quote->created_at->toDateTimeString()) }}</span>
                                                </h2>
                                                <div class="boxImg-text car-row" data-car-id="{{ $quote->id }}">

                                                    <div class="imgCol">
                                                        <img src="{{ $quote->image }}" class="" alt="image" />
                                                    </div>
                                                    <div class="textCol">
                                                        <span class="hideMob">Posted
                                                            {{ getTimeAgo($quote->created_at->toDateTimeString()) }}</span>
                                                        @if (!is_null($quote->vehicle_make_1) && !is_null($quote->vehicle_model_1))
                                                            <h2>2x Vehicles</h2>
                                                        @else
                                                            <h2>
                                                                {{ $quote->vehicle_make }}
                                                                {{ $quote->vehicle_model }}
                                                            </h2>
                                                        @endif
                                                        <ul>
                                                            <li>
                                                                <i>
                                                                    <svg width="16" height="22"
                                                                        viewBox="0 0 16 22" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M8.00002 0.16C7.5361 0.15999 7.16001 0.536063 7.16 0.999982C7.15999 1.4639 7.53606 1.83999 7.99998 1.84L8.00002 0.16ZM10.6782 1.5264L10.9964 0.748992L10.9961 0.748881L10.6782 1.5264ZM13.8198 4.08L13.1238 4.5503L13.1243 4.55106L13.8198 4.08ZM15 7.916H15.84L15.84 7.91465L15 7.916ZM12.949 12.8062L12.271 12.3103C12.2608 12.3243 12.251 12.3386 12.2417 12.3531L12.949 12.8062ZM10.9162 15.98L10.2088 15.5269L10.2059 15.5316L10.9162 15.98ZM8 20.6L7.2901 21.049C7.44414 21.2926 7.71225 21.4401 8.0004 21.44C8.28855 21.4399 8.55652 21.292 8.71033 21.0484L8 20.6ZM5.0838 15.9898L5.79371 15.5407L5.79151 15.5373L5.0838 15.9898ZM3.051 12.8104L3.75871 12.3579C3.74942 12.3434 3.73969 12.3291 3.72952 12.3152L3.051 12.8104ZM1 7.9202L0.16 7.91937V7.9202H1ZM2.1802 4.08L2.87569 4.55106L2.87573 4.551L2.1802 4.08ZM5.3218 1.5306L5.63951 2.3082L5.64092 2.30762L5.3218 1.5306ZM8.00124 1.84C8.46516 1.83932 8.84068 1.46268 8.84 0.998763C8.83932 0.534845 8.46268 0.159318 7.99876 0.160001L8.00124 1.84ZM8 9.38182C7.53608 9.38182 7.16 9.7579 7.16 10.2218C7.16 10.6857 7.53608 11.0618 8 11.0618V9.38182ZM8 4.77022C7.53608 4.77022 7.16 5.1463 7.16 5.61022C7.16 6.07414 7.53608 6.45022 8 6.45022V4.77022ZM8.02068 11.07C8.48445 11.0585 8.85116 10.6733 8.83973 10.2095C8.82829 9.74574 8.44306 9.37903 7.97928 9.39046L8.02068 11.07ZM5.95582 9.09437L6.67981 8.66841L5.95582 9.09437ZM5.95582 6.75585L5.23184 6.32989L5.95582 6.75585ZM7.97928 6.45975C8.44306 6.47119 8.82829 6.10449 8.83973 5.64071C8.85116 5.17693 8.48446 4.7917 8.02068 4.78026L7.97928 6.45975ZM7.99998 1.84C8.8094 1.84002 9.61108 1.99759 10.3603 2.30392L10.9961 0.748881C10.0451 0.360035 9.02746 0.160022 8.00002 0.16L7.99998 1.84ZM10.36 2.30381C11.4829 2.76336 12.4445 3.54504 13.1238 4.5503L14.5158 3.6097C13.6508 2.32959 12.4262 1.3342 10.9964 0.748992L10.36 2.30381ZM13.1243 4.55106C13.7974 5.54482 14.1581 6.7171 14.16 7.91735L15.84 7.91465C15.8375 6.37945 15.3762 4.88002 14.5153 3.60894L13.1243 4.55106ZM14.16 7.916C14.16 8.72866 14.0336 9.33192 13.7568 9.95594C13.4676 10.608 13.0038 11.3082 12.271 12.3103L13.627 13.3021C14.3614 12.298 14.9231 11.4701 15.2926 10.6371C15.6745 9.77608 15.84 8.93734 15.84 7.916H14.16ZM12.2417 12.3531L10.2089 15.5269L11.6235 16.4331L13.6563 13.2593L12.2417 12.3531ZM10.2059 15.5316L7.28967 20.1516L8.71033 21.0484L11.6265 16.4284L10.2059 15.5316ZM8.7099 20.151L5.7937 15.5408L4.3739 16.4388L7.2901 21.049L8.7099 20.151ZM5.79151 15.5373L3.75871 12.3579L2.34329 13.2629L4.37609 16.4423L5.79151 15.5373ZM3.72952 12.3152C2.99627 11.3105 2.5324 10.6102 2.24307 9.95836C1.96633 9.33489 1.84 8.73275 1.84 7.9202H0.16C0.16 8.94165 0.325572 9.7794 0.707534 10.6399C1.0769 11.4721 1.63853 12.2999 2.37248 13.3056L3.72952 12.3152ZM1.84 7.92103C1.84119 6.71953 2.20189 5.54586 2.87569 4.55106L1.48471 3.60894C0.622887 4.88135 0.161527 6.38255 0.16 7.91937L1.84 7.92103ZM2.87573 4.551C3.55555 3.54711 4.51715 2.76676 5.63951 2.3082L5.00409 0.752999C3.57488 1.33694 2.35036 2.33063 1.48467 3.609L2.87573 4.551ZM5.64092 2.30762C6.38988 2.00002 7.19157 1.84119 8.00124 1.84L7.99876 0.160001C6.97101 0.161514 5.95338 0.363125 5.00268 0.75358L5.64092 2.30762ZM8 11.0618C9.12389 11.0618 10.1624 10.4622 10.7243 9.48892L9.26942 8.64892C9.00758 9.10244 8.52368 9.38182 8 9.38182V11.0618ZM10.7243 9.48892C11.2863 8.5156 11.2863 7.31643 10.7243 6.34312L9.26942 7.18312C9.53126 7.63664 9.53126 8.1954 9.26942 8.64892L10.7243 9.48892ZM10.7243 6.34312C10.1624 5.3698 9.12389 4.77022 8 4.77022V6.45022C8.52368 6.45022 9.00758 6.7296 9.26942 7.18312L10.7243 6.34312ZM7.97928 9.39046C7.44715 9.40358 6.94973 9.12719 6.67981 8.66841L5.23184 9.52033C5.81113 10.5049 6.87865 11.0981 8.02068 11.07L7.97928 9.39046ZM6.67981 8.66841C6.40989 8.20964 6.40989 7.64058 6.67981 7.18181L5.23184 6.32989C4.65254 7.31448 4.65254 8.53574 5.23184 9.52033L6.67981 8.66841ZM6.67981 7.18181C6.94973 6.72303 7.44715 6.44664 7.97928 6.45975L8.02068 4.78026C6.87865 4.75212 5.81113 5.34529 5.23184 6.32989L6.67981 7.18181Z"
                                                                            fill="#52D017"></path>
                                                                    </svg>
                                                                </i>
                                                                <span
                                                                    class="text-decoration-none">{{ $quote->pickup_postcode ? hidePostcode(get_last_two_parts($quote->pickup_postcode)) : '-' }}</span>
                                                            </li>

                                                            <li>
                                                                <i>
                                                                    <svg width="16" height="22"
                                                                        viewBox="0 0 16 22" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M8.00002 0.16C7.5361 0.15999 7.16001 0.536063 7.16 0.999982C7.15999 1.4639 7.53606 1.83999 7.99998 1.84L8.00002 0.16ZM10.6782 1.5264L10.9964 0.748992L10.9961 0.748881L10.6782 1.5264ZM13.8198 4.08L13.1238 4.5503L13.1243 4.55106L13.8198 4.08ZM15 7.916H15.84L15.84 7.91465L15 7.916ZM12.949 12.8062L12.271 12.3103C12.2608 12.3243 12.251 12.3386 12.2417 12.3531L12.949 12.8062ZM10.9162 15.98L10.2088 15.5269L10.2059 15.5316L10.9162 15.98ZM8 20.6L7.2901 21.049C7.44414 21.2926 7.71225 21.4401 8.0004 21.44C8.28855 21.4399 8.55652 21.292 8.71033 21.0484L8 20.6ZM5.0838 15.9898L5.79371 15.5407L5.79151 15.5373L5.0838 15.9898ZM3.051 12.8104L3.75871 12.3579C3.74942 12.3434 3.73969 12.3291 3.72952 12.3152L3.051 12.8104ZM1 7.9202L0.16 7.91937V7.9202H1ZM2.1802 4.08L2.87569 4.55106L2.87573 4.551L2.1802 4.08ZM5.3218 1.5306L5.63951 2.3082L5.64092 2.30762L5.3218 1.5306ZM8.00124 1.84C8.46516 1.83932 8.84068 1.46268 8.84 0.998763C8.83932 0.534845 8.46268 0.159318 7.99876 0.160001L8.00124 1.84ZM8 9.38182C7.53608 9.38182 7.16 9.7579 7.16 10.2218C7.16 10.6857 7.53608 11.0618 8 11.0618V9.38182ZM8 4.77022C7.53608 4.77022 7.16 5.1463 7.16 5.61022C7.16 6.07414 7.53608 6.45022 8 6.45022V4.77022ZM8.02068 11.07C8.48445 11.0585 8.85116 10.6733 8.83973 10.2095C8.82829 9.74574 8.44306 9.37903 7.97928 9.39046L8.02068 11.07ZM5.95582 9.09437L6.67981 8.66841L5.95582 9.09437ZM5.95582 6.75585L5.23184 6.32989L5.95582 6.75585ZM7.97928 6.45975C8.44306 6.47119 8.82829 6.10449 8.83973 5.64071C8.85116 5.17693 8.48446 4.7917 8.02068 4.78026L7.97928 6.45975ZM7.99998 1.84C8.8094 1.84002 9.61108 1.99759 10.3603 2.30392L10.9961 0.748881C10.0451 0.360035 9.02746 0.160022 8.00002 0.16L7.99998 1.84ZM10.36 2.30381C11.4829 2.76336 12.4445 3.54504 13.1238 4.5503L14.5158 3.6097C13.6508 2.32959 12.4262 1.3342 10.9964 0.748992L10.36 2.30381ZM13.1243 4.55106C13.7974 5.54482 14.1581 6.7171 14.16 7.91735L15.84 7.91465C15.8375 6.37945 15.3762 4.88002 14.5153 3.60894L13.1243 4.55106ZM14.16 7.916C14.16 8.72866 14.0336 9.33192 13.7568 9.95594C13.4676 10.608 13.0038 11.3082 12.271 12.3103L13.627 13.3021C14.3614 12.298 14.9231 11.4701 15.2926 10.6371C15.6745 9.77608 15.84 8.93734 15.84 7.916H14.16ZM12.2417 12.3531L10.2089 15.5269L11.6235 16.4331L13.6563 13.2593L12.2417 12.3531ZM10.2059 15.5316L7.28967 20.1516L8.71033 21.0484L11.6265 16.4284L10.2059 15.5316ZM8.7099 20.151L5.7937 15.5408L4.3739 16.4388L7.2901 21.049L8.7099 20.151ZM5.79151 15.5373L3.75871 12.3579L2.34329 13.2629L4.37609 16.4423L5.79151 15.5373ZM3.72952 12.3152C2.99627 11.3105 2.5324 10.6102 2.24307 9.95836C1.96633 9.33489 1.84 8.73275 1.84 7.9202H0.16C0.16 8.94165 0.325572 9.7794 0.707534 10.6399C1.0769 11.4721 1.63853 12.2999 2.37248 13.3056L3.72952 12.3152ZM1.84 7.92103C1.84119 6.71953 2.20189 5.54586 2.87569 4.55106L1.48471 3.60894C0.622887 4.88135 0.161527 6.38255 0.16 7.91937L1.84 7.92103ZM2.87573 4.551C3.55555 3.54711 4.51715 2.76676 5.63951 2.3082L5.00409 0.752999C3.57488 1.33694 2.35036 2.33063 1.48467 3.609L2.87573 4.551ZM5.64092 2.30762C6.38988 2.00002 7.19157 1.84119 8.00124 1.84L7.99876 0.160001C6.97101 0.161514 5.95338 0.363125 5.00268 0.75358L5.64092 2.30762ZM8 11.0618C9.12389 11.0618 10.1624 10.4622 10.7243 9.48892L9.26942 8.64892C9.00758 9.10244 8.52368 9.38182 8 9.38182V11.0618ZM10.7243 9.48892C11.2863 8.5156 11.2863 7.31643 10.7243 6.34312L9.26942 7.18312C9.53126 7.63664 9.53126 8.1954 9.26942 8.64892L10.7243 9.48892ZM10.7243 6.34312C10.1624 5.3698 9.12389 4.77022 8 4.77022V6.45022C8.52368 6.45022 9.00758 6.7296 9.26942 7.18312L10.7243 6.34312ZM7.97928 9.39046C7.44715 9.40358 6.94973 9.12719 6.67981 8.66841L5.23184 9.52033C5.81113 10.5049 6.87865 11.0981 8.02068 11.07L7.97928 9.39046ZM6.67981 8.66841C6.40989 8.20964 6.40989 7.64058 6.67981 7.18181L5.23184 6.32989C4.65254 7.31448 4.65254 8.53574 5.23184 9.52033L6.67981 8.66841ZM6.67981 7.18181C6.94973 6.72303 7.44715 6.44664 7.97928 6.45975L8.02068 4.78026C6.87865 4.75212 5.81113 5.34529 5.23184 6.32989L6.67981 7.18181Z"
                                                                            fill="#ED1C24"></path>
                                                                    </svg>
                                                                </i>
                                                                <span
                                                                    class="text-decoration-none">{{ $quote->drop_postcode ? hidePostcode(get_last_two_parts($quote->drop_postcode)) : '-' }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                {{-- <h2 class="imgHeading">
                                                    <span>Posted
                                                        {{ getTimeAgo($quote->created_at->toDateTimeString()) }}</span>
                                                </h2> --}}
                                                <div class="contentBlockBtn">
                                                    <div class="leftList">
                                                        <ul class="col-6 px-0 car-row "
                                                            data-car-id="{{ $quote->id }}">
                                                            <li>
                                                                <b>Expiry date:</b>
                                                                <span class="font-weight-light">
                                                                    {{ formatCustomDate($quote->created_at->addDays(10)) }}
                                                                </span>
                                                            </li>
                                                            <li class="colorDivBlue">
                                                                <b>Delivery date:</b>
                                                                @if ($quote->delivery_timeframe_from)
                                                                    <span
                                                                        class="sub_color">{{ formatCustomDate($quote->delivery_timeframe_from) }}</span>
                                                                @else
                                                                    <span
                                                                        class="sub_color">{{ $quote->delivery_timeframe }}</span>
                                                                @endif
                                                            </li>

                                                            <li class="colorDivBlue">
                                                                <b>Delivery type:</b>
                                                                <span class="sub_color"> {{ $quote->how_moved }}</span>
                                                            </li>
                                                            <li class="colorDivBlue">
                                                                <b>Journey miles:</b>
                                                                <span
                                                                    class="sub_color">{{ str_replace(' mi', '', $quote->distance) }}</span>
                                                                <span class="grey">({{ $quote->duration }})</span>
                                                            </li>

                                                        </ul>
                                                        <ul class="col-6 px-0">
                                                            @php
                                                                $lowestBid = $quote->lowest_bid ?? 0;
                                                                $transporterQuotesCount =
                                                                    $quote->transporter_quotes_count ?? 0;
                                                            @endphp
                                                            @if ($transporterQuotesCount > 0)
                                                                <li class="colorDivgreen car-row"
                                                                    data-car-id="{{ $quote->id }}">
                                                                    <span><b>Current lowest bid:</b></span>
                                                                    <span class="sub_color">£{{ $lowestBid }}</span>
                                                                </li>
                                                            @else
                                                                <li class="colorDivgreen car-row"
                                                                    data-car-id="{{ $quote->id }}">
                                                                    <span><b>Current lowest bid:</b></span>
                                                                    <span class="sub_color">£0</span>
                                                                </li>
                                                            @endif
                                                            <li class="colorDivBlue  mb-2 car-row"
                                                                data-car-id="{{ $quote->id }}">
                                                                <b>Transporters bidding: </b>
                                                                @if ($transporterQuotesCount > 0)
                                                                    <span
                                                                        class="sub_color">{{ $transporterQuotesCount }}</span>
                                                                @else
                                                                    <span class="sub_color">0</span>
                                                                @endif
                                                            </li>
                                                            <li class="row mx-0 w-100 align-items-end mb-0">
                                                                <div class="btnCol">
                                                                    @if ($quote->quoteByTransporter)
                                                                        <a href="{{ route('transporter.job_information', $quote->id) }}"
                                                                            class="w-100 mt-0 make_offer_btn checkStatus">
                                                                            Edit bid
                                                                        </a>
                                                                    @else
                                                                        <a href="{{ route('transporter.job_information', $quote->id) }}"
                                                                            {{-- onclick="share_give_quote('{{ $quote->id }}');" --}}
                                                                            class="w-100 mt-0 make_offer_btn checkStatus">Place
                                                                            bid</a>
                                                                    @endif
                                                                </div>
                                                                <div class="iconDiv ml-4">
                                                                    @if ($quote->watchlist)
                                                                        <a href="javascript:;" style="margin-left: auto;"
                                                                            class=""
                                                                            onclick="removeToWatchlist('{{ $quote->id }}');">

                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16" height="16"
                                                                                fill="#9C9C9C" class="bi bi-eye-slash"
                                                                                viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                                                                <path
                                                                                    d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                                                                <path
                                                                                    d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                                                                            </svg>
                                                                        </a>
                                                                    @else
                                                                        <a href="javascript:;" style="margin-left: auto;"
                                                                            class=""
                                                                            onclick="addToWatchlist('{{ $quote->id }}');"
                                                                            style="margin-left: auto;">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16" height="16"
                                                                                fill="none" stroke="#9C9C9C"
                                                                                class="bi bi-eye" viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M8 2.5C4.5 2.5 1.73 5.11.64 8c1.09 2.89 3.86 5.5 7.36 5.5s6.27-2.61 7.36-5.5C14.27 5.11 11.5 2.5 8 2.5z" />
                                                                                <circle cx="8" cy="8"
                                                                                    r="3" />
                                                                            </svg>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    @if ($quote->quoteByTransporter)
                                                        <div class="actionDiv">
                                                            <div class="rotated-banner">Bidding</div>
                                                        </div>
                                                    @else
                                                        @if ($quote->created_at->timezone('Europe/London')->diffInHours(now('Europe/London')) < 1)
                                                            <div class="actionDiv">
                                                                <div class="rotated-banner green">New</div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div id="idLoadData">
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pagination before_search">
        {{ $quotes->links() }}
    </div>


    <div class="modal get_quote fade" id="quote" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> Place your bid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.6584 0.166626L6.00008 4.82496L1.34175 0.166626L0.166748 1.34163L4.82508 5.99996L0.166748 10.6583L1.34175 11.8333L6.00008 7.17496L10.6584 11.8333L11.8334 10.6583L7.17508 5.99996L11.8334 1.34163L10.6584 0.166626Z"
                                    fill="#000" />
                            </svg>
                        </span>
                    </button>
                </div>
                <form id="main_form" method="post" action="{{ route('transporter.submit_offer') }}" class="bid_form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <span class="icon_includes">£</span>
                            <input type="tel" class="form-control" aria-describedby="emailHelp"
                                placeholder="Enter bid (inc vat)" id="amount" name="amount">
                            <!-- <p style="font-size:12px; margin-top: 10px;"><b> Note:</b> The amount you bid will be the total amount you get paid directly by the customer.</p> -->
                            <div class="modal_current">
                                <p>Current lowest bid: <span class="lowAmount">£0</span></p>
                                <p>Transporters bidding: <span class="red bidCount">0</span></p>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0px">
                            <textarea placeholder="Send a professional message for a better chance of winning the job..."
                                class="form-control textarea" id="message" name="message"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: 10px;">
                        <input type="hidden" name="quote_id" id="quote_id" value="">
                        <p class="position-relative pl-4" style="line-height:16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="20" height="20"
                                style="left:0; top:0;" class="position-absolute" viewBox="0 0 24 24" strokeWidth={1.5}
                                stroke="currentColor" className="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            Do not share any contact details here. We will provide you with the users contact details after
                            they have accepted your quote.
                        </p>
                        <button type="submit" class="submit_btn">Place bid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT  --}}
    <div class="modal get_quote fade" id="quoteEdit" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> Edit bid</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onClick="adjustbackdrop()">
                        <span aria-hidden="true">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.6584 0.166626L6.00008 4.82496L1.34175 0.166626L0.166748 1.34163L4.82508 5.99996L0.166748 10.6583L1.34175 11.8333L6.00008 7.17496L10.6584 11.8333L11.8334 10.6583L7.17508 5.99996L11.8334 1.34163L10.6584 0.166626Z"
                                    fill="#000" />
                            </svg>
                        </span>
                    </button>
                </div>
                <form id="editQuoteForm" action="{{ route('transporter.submit_offer') }}" method="POST"
                    class="bid_form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <span class="icon_includes">£</span>
                            <input type="tel" class="form-control" aria-describedby="emailHelp"
                                placeholder="Enter bid (inc vat)" id="editamount" name="amount">
                            <!-- <p style="font-size:12px; margin-top: 10px;"><b> Note:</b> The amount you bid will be the total amount you get paid directly by the customer.</p> -->
                            <div class="modal_current">
                                <p>Current lowest bid: <span class="lowAmount">£0</span></p>
                                <p>Transporters bidding: <span class="red bidCount">0</span></p>
                            </div>
                        </div>
                        {{-- <div class="form-group" style="margin-bottom:0px">
                            <textarea placeholder="Send a professional message for a better chance of winning the job..."
                                class="form-control textarea" id="editmessage" name="message"></textarea>
                        </div> --}}
                    </div>
                    <div class="modal-footer" style="margin-top: 10px;">
                        <input type="hidden" name="quote_id" id="quote_edit_id" value="">
                        {{-- <p><b> Note:</b> Do not share any contact information or company names, we will provide you with the
                            customers details after they have accepted your quote.</p> --}}
                        <button type="submit" class="submit_btn">Submit bid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- The Modal -->
    <div class="modal fade" id="carDetailsModal" tabindex="-1" aria-labelledby="carDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <div>
                        <span id="backButton">
                            <svg width="7" height="13" viewBox="0 0 7 13" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g opacity="0.5">
                                    <path d="M6 11.5L1 6.5L6 1.5" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                            Back
                        </span>
                    </div>
                    <div class="expiryDiv" id="expiry_date">

                    </div>
                    <div>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.292893 15.2929C-0.0976311 15.6834 -0.0976311 16.3166 0.292893 16.7071C0.683417 17.0976 1.31658 17.0976 1.70711 16.7071L0.292893 15.2929ZM9.20711 9.20711C9.59763 8.81658 9.59763 8.18342 9.20711 7.79289C8.81658 7.40237 8.18342 7.40237 7.79289 7.79289L9.20711 9.20711ZM7.79289 7.79289C7.40237 8.18342 7.40237 8.81658 7.79289 9.20711C8.18342 9.59763 8.81658 9.59763 9.20711 9.20711L7.79289 7.79289ZM16.7071 1.70711C17.0976 1.31658 17.0976 0.683417 16.7071 0.292893C16.3166 -0.0976311 15.6834 -0.0976311 15.2929 0.292893L16.7071 1.70711ZM9.20711 7.79289C8.81658 7.40237 8.18342 7.40237 7.79289 7.79289C7.40237 8.18342 7.40237 8.81658 7.79289 9.20711L9.20711 7.79289ZM15.2929 16.7071C15.6834 17.0976 16.3166 17.0976 16.7071 16.7071C17.0976 16.3166 17.0976 15.6834 16.7071 15.2929L15.2929 16.7071ZM7.79289 9.20711C8.18342 9.59763 8.81658 9.59763 9.20711 9.20711C9.59763 8.81658 9.59763 8.18342 9.20711 7.79289L7.79289 9.20711ZM1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L1.70711 0.292893ZM1.70711 16.7071L9.20711 9.20711L7.79289 7.79289L0.292893 15.2929L1.70711 16.7071ZM9.20711 9.20711L16.7071 1.70711L15.2929 0.292893L7.79289 7.79289L9.20711 9.20711ZM7.79289 9.20711L15.2929 16.7071L16.7071 15.2929L9.20711 7.79289L7.79289 9.20711ZM9.20711 7.79289L1.70711 0.292893L0.292893 1.70711L7.79289 9.20711L9.20711 7.79289Z"
                                    fill="#9C9C9C" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal Body -->
                <div class="modal-body modalMainBody" id="carDetailsModalBody">
                    <!-- Modal content will be dynamically updated here -->
                </div>
            </div>
        </div>
    </div>

    {{-- d4dDeveloper-r  start --}}
    @include('transporter.Modal.saveSearch')
    {{-- End --}}

@endsection

@section('script')
    <script src="{{ asset('assets/web/js/admin.js') }}"></script>
    <script src="{{ asset('assets/web/js/main.js') }}"></script>
    <script src="{{ asset('assets/web/js/rangeslider.js') }}"></script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ config('constants.google_map_key') }}&libraries=places"></script>
    {{--    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.google_map_key') }}&loading=async&libraries=places&callback=initMap" async defer></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        var globalSiteUrl = '<?php echo $path = url('/'); ?>'
        var carDetails = @json($quotes);
        var isMobile = '{{ isMobile() }}';

        $.validator.addMethod("noPhoneOrEmail", function(value, element) {
            var contains_email = /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i.test(value);
            var contains_six_or_more_digits = value.replace(/\s+/g, '').match(/\d{7,}/);
            return !(contains_email || contains_six_or_more_digits);
        });

        $.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || parseFloat(value) > 0;
        }, "You must enter an amount greater than zero");

        $("#main_form").validate({
            rules: {
                amount: {
                    required: true,
                    noPhoneOrEmail: false,
                    greaterThanZero: true
                },
                message: {
                    required: true,
                    noPhoneOrEmail: true,
                },
            },
            messages: {
                amount: {
                    required: 'Please enter amount',
                    noPhoneOrEmail: `Do not share contact information or you will be banned.`,
                    greaterThanZero: 'You must enter an amount greater than zero'
                },
                message: {
                    required: 'Please enter message',
                    noPhoneOrEmail: `Do not share contact information or you will be banned.`
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.insertAfter($(element));
            },
            submitHandler: function(form) {
                var submitButton = $(form).find('button[type="submit"]');
                submitButton.prop('disabled', true).text('Submitting...');
                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: '<span class="swal-title">Bid placed</span>',
                                html: '<span class="swal-text">Your bid has been placed successfully.</span>',
                                confirmButtonColor: '#52D017',
                                confirmButtonText: 'Dismiss',
                                customClass: {
                                    title: 'swal-title',
                                    htmlContainer: 'swal-text-container',
                                    popup: 'swal-popup', // Add custom class for the popup
                                    cancelButton: 'swal-button--cancel' // Add custom class for the cancel button
                                },
                                showCloseButton: true, // Add this line to show the close button
                                showConfirmButton: true, // Add this line to hide the confirm button
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed || result.isDismissed) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            submitButton.prop('disabled', false).text('Submit');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                            var errors = jqXHR.responseJSON.errors;
                            $('#main_form').find('span.error').remove();
                            $.each(errors, function(key, errorMessages) {
                                alert(key)
                                var element = $('#' + key);
                                if (element.length > 0) {
                                    var errorElement = element.next('span.error');
                                    if (errorElement.length === 0) {
                                        errorElement = $('<span id=' + key +
                                            '-error class="error"></span>');
                                        element.after(errorElement);
                                    }

                                    errorElement.text(errorMessages[0]);
                                }
                            });
                        } else {
                            console.error('Unexpected error:', textStatus, errorThrown);
                        }
                        submitButton.prop('disabled', false).text('Submit');
                    }
                });
            }
        });

        // D4dDeveloper-R 04-10-2024
        $(document).on('click', '#saveSrch', function() {
            // alert("clicked");
            $("#srchName").val('');
            $('#emailNtf').prop('checked', false);
            $("#saveSrchModal").modal('show');
        });

        $("#saveSrchForm").submit(function(e) {
            e.preventDefault();
            var pick_area = $("#search_pick_up_area").val();
            var drop_area = $("#search_drop_off_area").val();
            var search_name = $("#srchName").val();
            var isChecked = $('#save-search').prop('checked');
            $("#srchName").next("span.error").remove();
            if (srchName === "") {
                $("#srchName").after('<span class="error" style="color:red;">This field is required</span>');
            }
            $.ajax({
                url: "{{ route('transporter.save.search') }}",
                type: "POST",
                data: {
                    pick_area: pick_area,
                    drop_area: drop_area,
                    search_name: search_name,
                    emailNtf: isChecked,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log('Success:', response);
                    $("#srchName").val('');
                    $('#emailNtf').prop('checked', false);
                    if (response.success) {
                        $("#srchName").val('');
                        $('#emailNtf').prop('checked', false);
                        $("#saveSrchModal").modal('hide');
                        toastr.success(response.message);
                        $(".search_resu_sec").addClass('adjust-space-without-btn');
                        $(".search_resu_sec").siblings('.savebtnS').addClass('d-none');
                    } else {
                        $("#srchName").val('');
                        $('#emailNtf').prop('checked', false);
                        $("#saveSrchModal").modal('hide');
                        toastr.error(response.message);
                    }


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error:', jqXHR.responseText || errorThrown);
                    $("#srchName").val('');
                    $('#emailNtf').prop('checked', false);
                }
            });
        });
        // end

        $("#editQuoteForm").validate({
            rules: {
                amount: {
                    required: true,
                    noPhoneOrEmail: false,
                    greaterThanZero: true
                },
                message: {
                    required: true,
                    noPhoneOrEmail: true,
                },
            },
            messages: {
                amount: {
                    required: 'Please enter amount',
                    noPhoneOrEmail: `Do not share contact information or you will be banned.`,
                    greaterThanZero: 'You must enter an amount greater than zero'
                },
                message: {
                    required: 'Please enter message',
                    noPhoneOrEmail: `Do not share contact information or you will be banned.`
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.insertAfter($(element));
            },
            submitHandler: function(form) {
                var submitButton = $(form).find('button[type="submit"]');
                submitButton.prop('disabled', true).text('Submitting...');
                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: '<span class="swal-title">Bid placed</span>',
                                html: '<span class="swal-text">Your bid has been placed successfully.</span>',
                                confirmButtonColor: '#52D017',
                                confirmButtonText: 'Dismiss',
                                customClass: {
                                    title: 'swal-title',
                                    htmlContainer: 'swal-text-container',
                                    popup: 'swal-popup', // Add custom class for the popup
                                    cancelButton: 'swal-button--cancel' // Add custom class for the cancel button
                                },
                                showCloseButton: true, // Add this line to show the close button
                                showConfirmButton: true, // Add this line to hide the confirm button
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed || result.isDismissed) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            submitButton.prop('disabled', false).text('Submit');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                            var errors = jqXHR.responseJSON.errors;
                            $('#main_form').find('span.error').remove();
                            $.each(errors, function(key, errorMessages) {
                                alert(key)
                                var element = $('#' + key);
                                if (element.length > 0) {
                                    var errorElement = element.next('span.error');
                                    if (errorElement.length === 0) {
                                        errorElement = $('<span id=' + key +
                                            '-error class="error"></span>');
                                        element.after(errorElement);
                                    }

                                    errorElement.text(errorMessages[0]);
                                }
                            });
                        } else {
                            console.error('Unexpected error:', textStatus, errorThrown);
                        }
                        submitButton.prop('disabled', false).text('Submit');
                    }
                });
            }
        });

        function share_give_quote(id) {
            $('#quote_id').val(id);
            var quotes = @json($quotes);
            var selectedQuote = quotes.data.find(quote => quote.id == id);
            if (selectedQuote) {
                var lowestBid = selectedQuote.lowest_bid ? selectedQuote.lowest_bid : 0;
                var bidCount = selectedQuote.transporter_quotes_count ? selectedQuote.transporter_quotes_count : 0;

                $('.lowAmount').text('£' + lowestBid);
                $('.bidCount').text(bidCount);
                // Prevent closing quote modal when clicking outside
                $('#quote').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                // if(isMobile) {
                $('#quote').css('z-index', parseInt($('#carDetailsModal').css('z-index')) + 10);
                $('.modal-backdrop').css('z-index', parseInt($('#carDetailsModal').css('z-index')) + 5);
                // }
                $('#quote').modal('show');
            }
        }

        function adjustbackdrop() {
            $('.modal-backdrop').css('z-index', '1040');
        }

        function share_edit_quote(id) {
            $('#quote_edit_id').val(id);
            var quotes = @json($quotes);
            var selectedQuote = quotes.data.find(quote => quote.id == id);
            if (selectedQuote) {
                var lowestBid = selectedQuote.lowest_bid ? selectedQuote.lowest_bid : 0;
                var bidCount = selectedQuote.transporter_quotes_count ? selectedQuote.transporter_quotes_count : 0;
                // $('#editamount').val(selectedQuote.quote_by_transporter.price);
                $('#editmessage').val(selectedQuote.quote_by_transporter.message);
                $('.lowAmount').text('£' + lowestBid);
                $('.bidCount').text(bidCount);
                // Prevent closing quote modal when clicking outside
                $('#quoteEdit').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                // if(isMobile) {
                $('#quoteEdit').css('z-index', parseInt($('#carDetailsModal').css('z-index')) + 10);
                $('.modal-backdrop').css('z-index', parseInt($('#carDetailsModal').css('z-index')) + 5);
                // }
                $('#quoteEdit').modal('show');
            }
        }

        function myFunction(x) {
            if (x.matches) { // If media query matches
                $(document).ready(function() {
                    $('.where_custom').click(function() {
                        $('.where_box').slideToggle("slow");
                        $('#pickupLabel').hide();
                        $('#search_pick_up_area').attr('placeholder', 'Where from ?');
                    });
                    $('.drop_off_box').click(function() {
                        $('.to_box').slideToggle("slow");
                        $('#dropoffLabel').hide();
                        $('#search_drop_off_area').attr('placeholder', 'Where to ?');
                    });
                });
            } else {
                $(document).ready(function() {
                    $('.where_custom').click(function() {
                        $('.where_box').hide();
                    });
                });

                $(document).ready(function() {
                    $('.drop_off_box').click(function() {
                        $('.to_box').hide();
                    });
                });
            }
        }

        function addToWatchlist(quoteId) {
            $.ajax({
                url: "{{ route('transporter.watchlist.store') }}", // Replace with your route for adding to the watchlist
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    quote_id: quoteId // Quote ID to be sent
                },
                success: function(response) {
                    if (response.success) {
                        // Show a success message or update the UI accordingly
                        toastr.success('Job added to watchlist!');
                        setTimeout(function() {
                            location.reload(); // Reload the page
                        }, 2000);
                    } else {
                        // Handle the case where the operation wasn't successful
                        toastr.error(response.message); // Display the specific message returned from the server
                    }
                },
                error: function(xhr, status, error) {
                    // General error handling for unexpected issues
                    console.error('An error occurred:', error);
                    toastr.error('An error occurred while adding to the watchlist.');
                }
            });
        }

        // Listen for the quote modal to be hidden
        $('#quote').on('hidden.bs.modal', function(e) {

            $('#quote').css('z-index', '');
            $('.modal-backdrop').remove(); // Ensure the backdrop is removed

            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto'); // Re-enable scrolling if it was disabled
        });

        var x = window.matchMedia("(max-width: 767px)")

        myFunction(x);

        x.addEventListener("change", function() {
            myFunction(x);
        });

       /* var jobInfoUrl = "{{ route('transporter.job_information', ':id') }}";

        $(document).on('click', '.car-row', function(e) {
            e.preventDefault(); // Prevent default action initially

            var carId = $(this).data('car-id');
            if (!carId) {
                console.log('Job ID is missing');
                return;
            }

            $('.checkStatus').trigger('click'); // Trigger checkStatus

            // Delay redirection to wait for Swal or other processes
            setTimeout(function() {
                if (!$('.swal2-container')
                    .length) { // If no SweetAlert popup is open, proceed with redirect
                    var url = jobInfoUrl.replace(':id', carId); // Replace placeholder with actual ID
                    window.location.href = url; // Redirect to the URL
                }
            }); // Adjust delay time if needed
        });*/

        $(document).ready(function() {
            $("#jobsrch_form_blog").validate({
                rules: {
                    search_pick_up_area: {
                        required: true
                    },
                    search_drop_off_area: {
                        required: false
                    }
                },
                messages: {
                    search_pick_up_area: {
                        required: "Please enter collection area"
                    },
                    search_drop_off_area: {
                        required: "Please enter delivery area"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('error-message'); // Add custom class for styling
                    error.insertAfter(element);
                    element.closest('.form-group').addClass('error-margin');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('error-margin');
                }
            });

            $('#backButton').on('click', function() {
                $('#carDetailsModal').modal('hide');
            });

            $('.local_srch_box').click(function() {
                $('.local_srch_fillterbx').slideToggle("slow");
            });

            $('.where_box label').click(function() {
                var location = $(this).text();

                $('#search_pick_up_area').val(location);
                $('.where_box').hide();
                var errorElement = $('#search_pick_up_area-error');
                if (errorElement.length) {
                    $('#search_pick_up_area').closest('.form-group').removeClass('error-margin');
                    errorElement.remove();
                }
            });

            $('.to_box label').click(function() {
                var location = $(this).text();
                $('#search_drop_off_area').val(location);
                $('.to_box').hide();
                var errorElement = $('#search_drop_off_area-error');
                if (errorElement.length) {
                    $('#search_drop_off_area').closest('.form-group').removeClass('error-margin');
                    errorElement.remove();
                }
            });

            $('#search_pick_up_area').on('keyup', function() {
                if ($(this).val().length > 0) {
                    $('.where_box').hide();
                } else {
                    if (isMobile)
                        $('.where_box').show();
                }
            });

            $('#search_drop_off_area').on('keyup', function() {
                if ($(this).val().length > 0) {
                    $('.to_box').hide();
                } else {
                    if (isMobile)
                        $('.to_box').show();
                }
            })

            const urlParams = new URLSearchParams(window.location.search);
            const openModalId = urlParams.get('share_quotation');

            if (openModalId) {
                const carRowDiv = $(`ul.car-row[data-car-id="${openModalId}"]`);
                if (carRowDiv.length) {
                    simulateClick(carRowDiv);
                }
                if (history.pushState) {
                    const cleanUrl = window.location.protocol + "//" + window.location.host + window.location
                        .pathname;
                    window.history.pushState({
                        path: cleanUrl
                    }, '', cleanUrl);
                }
            }

            function simulateClick(element) {
                element.trigger('click');
            }

            var $slider = $('.slider');
            $slider.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide) {
                var i = (currentSlide ? currentSlide : 0) + 1;
                $('.current-slide').text(i);
                $('.total-slides').text(slick.slideCount);
            });

            $slider.slick({
                infinite: false,
                speed: 300,
                slidesToShow: 1,
                adaptiveHeight: true,
                prevArrow: '<div class="slick-prev"><svg width="15" height="18" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.0756 16.5115L1.85822 10.7965C1.31976 10.4441 1 9.87387 1 9.26607C1 8.65827 1.31976 8.08803 1.85822 7.73561L10.0756 1.48823C10.7708 0.976677 11.7151 0.857068 12.5347 1.17696C13.3543 1.49685 13.917 2.20438 14 3.01972V14.984L14 14.984C13.9156 15.7986 13.3523 16.5049 12.533 16.8238C11.7136 17.1427 10.7702 17.0228 10.0756 16.5115Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>',
                nextArrow: '<div class="slick-next"><svg width="15" height="18" viewBox="0 0 15 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.9244 1.48852L13.1418 7.20349C13.6802 7.5559 14 8.12613 14 8.73393C14 9.34173 13.6802 9.91197 13.1418 10.2644L4.9244 16.5118C4.22923 17.0233 3.28491 17.1429 2.46532 16.823C1.64573 16.5032 1.08303 15.7956 1 14.9803L1 3.01597C1.08445 2.20143 1.6477 1.49505 2.46703 1.17615C3.28636 0.857255 4.22984 0.977185 4.9244 1.48852Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>'
            });

            $('#message').on('keydown paste input', function(event) {
                if (event.type === 'keydown' && event.key >= '0' && event.key <= '9') {
                    event.preventDefault();
                }
                if (event.type === 'paste') {
                    let pastedData = event.originalEvent.clipboardData.getData('text');
                    if (/\d/.test(pastedData)) {
                        event.preventDefault();
                    }
                }
                if (event.type === 'input') {
                    let newValue = $(this).val().replace(/[0-9]/g, '');
                    $(this).val(newValue);
                }
            });

        });

        function formatAddress(address) {
            var addressParts = address.split(',');
            var firstPart = addressParts[0].trim();
            var lastTwoParts = addressParts.slice(-2);
            var limitedAddress = lastTwoParts.join(',');
            return limitedAddress;
        }

        function formatCustomDate(date) {
            var d = new Date(date);
            var day = String(d.getDate()).padStart(2, '0');
            var month = String(d.getMonth() + 1).padStart(2, '0'); // getMonth() returns month from 0-11
            var year = String(d.getFullYear()).slice(-2); // Get last two digits of the year

            return `${day}/${month}/${year}`;
        }

        const setActive = (el, active) => {
            const formField = el.parentNode
            if (active) {
                formField.classList.add('field_active')
            } else {
                el.value === '' ?
                    formField.classList.remove('field_filled') :
                    formField.classList.add('field_filled')
            }
        }

        const formControls = document.querySelectorAll('.form-control');

        // Add event listeners for focus and blur to form-control elements
        formControls.forEach(el => {
            el.onblur = () => {
                setActive(el, false);
            };
            el.onfocus = () => {
                setActive(el, true);
            };
        });

        // Select all form-group divs
        const formGroups = document.querySelectorAll('.form-group');

        // Add event listeners for click to form-group divs
        formGroups.forEach(group => {
            group.onclick = (e) => {
                // Find the input element within the div
                const input = group.querySelector('.form-control');
                if (input && e.target !== input) {
                    input.focus();
                }
            };
        });

        // reset field
        function resetcode() {
            var element = document.getElementByClass("resetdata");
            element.reset();
        }

        function fetch_data(page, str = '') {

            if (str == '') {
                $('#popup').addClass('show'); // Show the popup
            }
            var search_pick_up_area = $('#search_pick_up_area').val();
            var search_drop_off_area = $('#search_drop_off_area').val();
            $.ajax({
                url: globalSiteUrl + "/transporter/find_job?page=" + page,
                data: {

                    search_pick_up_area: search_pick_up_area,
                    search_drop_off_area: search_drop_off_area,
                },
                type: "GET",
                success: function(res) {
                    // console.log(res);
                    // return;
                    if (res.success == true) {
                        $('#popup').removeClass('show');
                        $('.jobsrch_blogs, .mainContentDiv').addClass('d-none');
                        $('#idLoadData').html(res.data);
                        $('.jobsrch_form_blog').addClass('d-none');
                        $('.admin_job_top h3').text('Your results');
                        $('.pera_srch').text('Here are some jobs we’ve found that match your search.');
                        $('html, body').scrollTop(0);

                        checkAndHideSections();
                    } else {
                        $('#popup').removeClass('show');
                        toastr.error(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Response:', xhr.responseText); // Full
                }
            });
        }

        $('#search_job').on('click', function() {
            var form = $('#jobsrch_form_blog');
            // Trigger form validation
            if (form.valid()) {
                fetch_data(1);
            }
        });

        $(document).on('click', '.after_search a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#page').val(page);
            fetch_data(page, 'pagination');
        });

        $(document).on('click', '.before_search a', function(event) {
            event.preventDefault();
            var baseUrl = window.location.origin; // e.g., http://127.0.0.1:8000
            var path = '/transporter/new-jobs-new';
            var page = $(this).attr('href').split('page=')[1];
            var newUrl = baseUrl + path + '?page=' + page;
            window.location.href = newUrl;
        });

        function checkAndHideSections() {
            if ($('#idLoadData').children().length > 0) {
                $('.pagination.before_search').hide();
                $('.job-data').hide();

            } else {
                $('.pagination.before_search').show();
                $('.job-data').show();
            }
        }

        function removeToWatchlist(quoteId) {
            $.ajax({
                url: "{{ route('transporter.watchlist.remove') }}", // Replace with your route for adding to the watchlist
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    quote_id: quoteId // Quote ID to be sent
                },
                success: function(response) {
                    if (response.success) {
                        // Show a success message or update the UI accordingly
                        toastr.success('Job removed from watchlist!');
                        setTimeout(function() {
                            location.reload(); // Reload the page
                        }, 2000);
                    } else {
                        // Handle the case where the operation wasn't successful
                        toastr.error(response.message); // Display the specific message returned from the server
                    }
                },
                error: function(xhr, status, error) {
                    // General error handling for unexpected issues
                    console.error('An error occurred:', error);
                    toastr.error('An error occurred while adding to the watchlist.');
                }
            });
        }

        window.addEventListener("beforeunload", function () {
    localStorage.setItem("scrollPosition", window.scrollY);
});
    </script>
@endsection
