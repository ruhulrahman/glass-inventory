import $ from "jquery";
import Noty from "noty";

import waitMe from "./waitMe.min.js";
import moment from "moment";
import Hashids from "hashids";

import { Notify } from 'quasar'

waitMe($);


// $.ajaxSetup({
// 	headers:{
// 		'Api-Token': process.env.VUE_APP_API_TOKEN,
// 		'Access-Control-Allow-Origin': '*'
// 	}
// });

var base_url=process.env.VUE_APP_BASE_URL;

export default {
    data() {
        return {
            base_url: base_url,
            initialPagination: {
              // page: 5,
              rowsPerPage: 20,
              // rowsNumber: 0 //if getting data from a server
            },
            pagination: {
                currentPage: 1,
                totalRows: 0,
                perPage: 20,
                slOffset: 1,
            },
            paginationCustom: {
                currentPage: 1,
                totalRows: 0,
                perPage: 10,
                slOffset: 1,
            },
            paginationVerified: {
                currentPage: 1,
                totalRows: 0,
                perPage: 10,
                slOffset: 1,
            },
            paginationUnverified: {
                currentPage: 1,
                totalRows: 0,
                perPage: 10,
                slOffset: 1,
            },
            monthList: [
                { id: 1, label: "January" },
                { id: 2, label: "February" },
                { id: 3, label: "March" },
                { id: 4, label: "April" },
                { id: 5, label: "May" },
                { id: 6, label: "June" },
                { id: 7, label: "July" },
                { id: 8, label: "August" },
                { id: 9, label: "September" },
                { id: 10, label: "October" },
                { id: 11, label: "November" },
                { id: 12, label: "December" },
            ],
            yearList: [
                { id: 1, label: "2021" },
                { id: 2, label: "2022" },
                { id: 3, label: "2023" },
                { id: 4, label: "2024" },
                { id: 5, label: "2025" },
            ],
            checkInOutList: [
                { id: "In", label: "Check In" },
                { id: "Out", label: "Check Out" },
            ],
            entryPointList: [
                { id: 100, label: "Computer" },
                { id: 200, label: "Mobile" },
                { id: 300, label: "Tablet" },
                { id: 400, label: "Others" },
            ],
            userTypeList: [
                { id: "system_admin", label: "System Admin", color: "warning" },
                { id: "super_admin", label: "Super Admin", color: "danger" },
                { id: "client", label: "Client", color: "primary" },
                { id: "client_user", label: "Client User", color: "success" },
            ],
            activeStatusList: [
                { id: "active", label: "Active" },
                { id: "dective", label: "Deactive" },
            ],
            roleTypeList: [
                { id: "general", label: "General" },
                { id: "global", label: "Global" },
                { id: "special", label: "Special" },
            ],
            serviceTypes: [
                { id: 1, label: "Service" },
                { id: 2, label: "Product" },
            ],
        };
    },
    computed: {
        fileHeaders: function () {
            const api_token = localStorage.getItem("api_token");

            if (!api_token) {
                api_token = this.$store.state.api_token;
            }

            const headers = {
                Authorization: "Bearer " + api_token,
                "Access-Control-Allow-Origin": "*",
            };
            return headers;
        },
        auth_user: function () {
            return this.cn(this.$store.state, "site.auth_user", null);
        },
        dropdownList: function () {
            if (this.$store.state.dropdowns) {
                return this.$store.state.dropdowns;
            } else {
                return {
                    job_categories: [],
                    edu_levels: [],
                    edu_names: [],
                    edu_names_by_level: [],
                    emp_statuses: [],
                    resume_receives: [],
                    job_levels: [],
                    work_places: [],
                    job_locations: [],
                    statusGroups: [],
                    genders: [],
                    countries: [],
                    areaMap: [],
                    documentTypes: [],
                    departments: [],
                    roles: [],
                    designations: [],
                    leaveTypes: [],
                    times: [],
                    companyTypes: [],
                    services: [],
                    earlyLeaveReasons: [],
                };
            }
        },
        dialCodeCountryDropdownList: function () {
            return this.cn(this.dropdowns, 'countries').map((item) => {
                return {
                    id: item.id,
                    label: item.dial_label
                }
            })
        },
        designationDropdownList: function () {
          const designations = this.cn(this.dropdownList, 'designations')
          let designationArray = []
          if (designations.length) {
            designations.forEach(item => {
              if (item.company_id === this.auth_user.company_id) {
                designationArray.push(item)
              }
            })
          }
          return designationArray
        },
        departmentDropdownList: function () {
          const departments = this.cn(this.dropdownList, 'departments')
          let departmentsArray = []
          if (departments.length) {
            departments.forEach(item => {
              if (item.company_id === this.auth_user.company_id) {
                departmentsArray.push(item)
              }
            })
          }
          return departmentsArray
        },
        leaveTypesDropdownList: function () {
          const leaveTypes = this.cn(this.dropdownList, 'leaveTypes')
          let leaveTypesArray = []
          if (leaveTypes.length) {
            leaveTypes.forEach(item => {
              if (item.company_id === this.auth_user.company_id) {
                leaveTypesArray.push(item)
              }
            })
          }
          return leaveTypesArray
        },
        serviceDropdownList: function () {
          const services = this.cn(this.dropdownList, 'services')
          let servicesArray = []
          if (services.length) {
            services.forEach(item => {
              if (item.company_id === this.auth_user.company_id) {
                servicesArray.push(item)
              }
            })
          }
          return servicesArray
        },
        earlyLeaveReasonsDropdownList: function () {
          const earlyLeaveReasons = this.cn(this.dropdownList, 'earlyLeaveReasons')
          let earlyLeaveReasonsArray = []
          if (earlyLeaveReasons.length) {
            earlyLeaveReasons.forEach(item => {
              if (item.company_id === this.auth_user.company_id) {
                earlyLeaveReasonsArray.push(item)
              }
            })
          }
          return earlyLeaveReasonsArray
        },
        countryList: function () {
            const countries = this.dropdownList.countries;
            if (countries && countries.length) {
                return countries.map((item) => {
                    return {
                        id: item.id,
                        label: item.name,
                        currency_code: item.currency_code,
                    };
                });
            } else {
                return countries;
            }
        },
        countryCurrencyList: function () {
            const countries = this.dropdownList.countries;
            if (countries && countries.length) {
                return countries.map((item) => {
                    return {
                        id: item.id,
                        label: `${item.name} (${item.currency_code})`,
                    };
                });
            } else {
                return countries;
            }
        },
    },
    methods: {
        no_img: function (uri = "assets/img/placeholder.png") {
            return ref.apiUrl(uri);
        },
        // url: function(path, base_url=null){

        // 	if(!base_url){
        // 		base_url=this.base_url;
        // 	}

        // 	return `${base_url}/${path}`;

        // },
        apiUrl: function (path, base_url = null) {
            if (!base_url) {
                base_url = this.base_url;
            }
            return `${base_url}/${path}`;
            // return `${process.env.BASE_API_URL}/${path}`;
        },
        jq: function () {
            return $;
        },
        notify: function (msg = "No message specified", responseColor = "positive", position = '', icon = '') {
          let responsePosition = ''
          let responseIcon = ''
          if (position) {
            responsePosition= position
          } else {
            if (responseColor == 'positive') {
              responsePosition="top-right"
            } else {
              responsePosition="bottom"
            }
          }
          if (icon) {
            responseicon= position
          } else {
            if (responseColor == 'positive') {
              responseIcon="check_circle"
            } else {
              responseIcon="warning"
            }
          }

          Notify.create({ color: responseColor, message: msg, position: responsePosition, icon: responseIcon })
        },
        alert: function (
            msg = "No message specified",
            type = "success",
            callback = null
        ) {
            if (!msg) return null;

            new Noty({
                theme: "sunset",
                text: msg,
                type: type,
                timeout: 2000,
                callbacks: {
                    afterClose: callback,
                },
            }).show();
        },
        err_msg: function (err) {
            //console.log(err.status);

            if (err.status && err.status == 401) {
                this.$router.push("/logout");
                return null;
            }

            var msg = "Request failed to process, try again later.";

            if (err.responseJSON && err.responseJSON.msg) {
                msg = err.responseJSON.msg;
            } else if (err.message) {
                msg = err.message;
            }

            return msg;
        },
        catch_alert: async function (err, callback = null) {
            this.alert(err.message, "error", callback);
        },
        cn: function (obj, input, if_false = "") {
            var elements = input.split(".");

            for (var i = 0; i < elements.length; i++) {
                if (!obj || !obj[elements[i]]) {
                    return if_false;
                }

                obj = obj[elements[i]];
            }

            if (obj) return obj;
            return if_false;
        },
        ajax_setup: function (token_name = "api_token") {
            var ref = this;
            var api_token = localStorage.getItem(token_name);

            // if(localStorage.getItem(token_name)){
            // 	api_token=localStorage.getItem(token_name);
            // }
            if (!api_token) {
                api_token = this.$store.state.api_token;
            }

            var headers = {
                Accept: "application/json",
                Authorization: "Bearer " + api_token,
                // "Access-Control-Allow-Origin": "*",
                "Access-Control-Allow-Origin": this.base_url,
            };

            //if(ref.api_key) headers['Api-Key']=ref.api_key;

            ref.jq().ajaxSetup({
                headers: headers,
            });
        },
        limit_str: function (str, limit = 20, alt_str = "...") {
            return str.length > limit
                ? str.substring(0, limit - 3) + alt_str
                : str;
        },
        wait_me: function (selector, config = null) {
            var jq = this.jq();

            if (config) {
                jq(selector).waitMe(config);
            } else {
                jq(selector).waitMe({
                    effect: "facebook",
                    // color: 'grey',
                    text: "Please! Wait ...",
                });
            }
        },
        clone_object: function (value) {
            return Object.assign({}, value);
        },
        setup_urls: function () {
            this.base_url = this.$store.state.base_url;
            this.api_token = this.$store.state.api_token;
            //this.api_url=this.$store.state.api_url;
            //this.api_key=this.$store.state.api_key;
        },
        str_title: function (str) {
            return str.replace(/\w\S*/g, function (txt) {
                return (
                    txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
                );
            });
        },
        //Ruhul amin vai told you to make a component of this.
        paginationData(data) {
            this.pagination.currentPage = data.current_page;
            this.pagination.totalRows = data.total;
            this.pagination.perPage = data.per_page;
            this.pagination.slOffset =
                data.per_page * this.pagination.currentPage - data.per_page + 1;
        },
        paginationCustomData(data) {
            this.paginationCustom.currentPage = data.current_page;
            this.paginationCustom.totalRows = data.total;
            this.paginationCustom.perPage = data.per_page;
            this.paginationCustom.slOffset =
                data.per_page * this.paginationCustom.currentPage -
                data.per_page +
                1;
        },
        paginationVerifiedData(data) {
            this.paginationVerified.currentPage = data.current_page;
            this.paginationVerified.totalRows = data.total;
            this.paginationVerified.perPage = data.per_page;
            this.paginationVerified.slOffset =
                data.per_page * this.paginationVerified.currentPage -
                data.per_page +
                1;
        },
        paginationUnverifiedData(data) {
            this.paginationUnverified.currentPage = data.current_page;
            this.paginationUnverified.totalRows = data.total;
            this.paginationUnverified.perPage = data.per_page;
            this.paginationUnverified.slOffset =
                data.per_page * this.paginationUnverified.currentPage -
                data.per_page +
                1;
        },
        checkCurrentDateLessThenDate: function (dateValue) {
            const currentDate = this.dDate(new Date(), "YYYY-MM-DD");
            const anotherDate = this.dDate(dateValue, "YYYY-MM-DD");
            if (anotherDate >= currentDate) {
                return true;
            } else {
                return false;
            }
        },
        dDate: function (value, format = "D MMM YYYY") {
            return moment.utc(value).local().format(format);
        },
        dDateTime: function (value, format = "D MMM YYYY LT") {
            return moment.utc(value).local().format(format);
        },
        dTime: function (value, format = "LT") {
            return moment.utc(value).local().format(format);
        },
        dRealTime: function (value, format = "LT") {
            return moment(value).local().format(format);
        },
        rTime: function (value) {
            var today = new Date();
            var year = today.getFullYear();
            var mes = today.getMonth()+1;
            var dia = today.getDate();
            var fecha =year+"-"+mes+"-"+dia;
            return moment(fecha + ' ' + value).format('LT');
        },
        getBetweenHour: function (startTime, endTime) {
            const myEndTime = endTime ? new Date(endTime) : new Date();
            const myStartTime = new Date(startTime);
            const diffMs = myEndTime - myStartTime;
            const diffHrs = Math.floor((diffMs % 86400000) / 3600000);
            const diffMins = Math.round(
                ((diffMs % 86400000) % 3600000) / 60000
            );
            if (diffHrs > 1) {
                return `${diffHrs} Hours ${diffMins} min`;
            } else {
                return `${diffHrs} Hour ${diffMins} min`;
            }
        },
        dMonth: function (value, format = "MMM YYYY") {
            return moment(value).format(format);
        },
        dYear: function (value, format = "YYYY") {
            return moment(value).format(format);
        },
        dNow: function (value) {
            // return moment(value).fromNow()
            return moment.utc(value).local().fromNow();
        },
        integer: function (value = 0) {
            const integerValue = value | 0;
            return Number(integerValue).toLocaleString();
        },
        float: function (value = 0.0) {
            const integerValue = parseFloat(value);
            return Number(integerValue).toLocaleString();
        },
        float2: function (value = 0.0) {
            const double = parseFloat(value).toFixed(2);
            return Number(double).toLocaleString();
        },
        hash_id: function (value, encode = true) {
            var hashids = new Hashids("hashids_for_passing_url_id", 32);
            if (encode) {
                return hashids.encode(value);
            } else {
                return hashids.decode(value);
            }
        },
        check_uni_auth: async function () {
            var ref = this;
            var api_token = localStorage.getItem("student_api_token");

            if (!api_token) {
                ref.$router.push("/login");
                return;
            }
        },
        avatarText: function (value) {
            var matches = value.match(/\b(\w)/g);

            if (matches.length == 1) {
                return value.substring(0, 2).toLocaleUpperCase();
            } else {
                const data = matches.filter((item, index) => {
                    if (index < 2) {
                        return Object.assign({}, item);
                    }
                });
                return data.join("");
            }
        },
        // countries: async function(){

        // 	var ref=this;
        //     var jq=ref.jq();
        //     try {
        //         var res = await jq.get(ref.apiUrl('api/v1/common/ajax/countries'));
        //         return res.data.countries;

        //     } catch (err) {
        //         ref.alert(ref.err_msg(err), 'error');
        //     }

        // },
        random_number: function (limit = 10) {
            return Math.floor(Math.random() * (limit + 1));
        },
        remove_row: function (array_data, index) {
            if (index > -1) array_data.splice(index, 1);
        },
        img_on_error: function (ev) {
            ev.target.src = "https://via.placeholder.com/150?text=No+Image";
        },
        imageRenderer: function (inputEl, callback) {
            const inputImageRenderer = () => {
                const file = inputEl.value.files[0];
                const reader = new FileReader();

                reader.addEventListener(
                    "load",
                    () => {
                        callback(reader.result);
                    },
                    false
                );

                if (file) {
                    reader.readAsDataURL(file);
                }
            };
            return {
                inputImageRenderer,
            };
        },
        has_permission: function (permit_code){

            let permission_disable=this.$store.state.site.permission_disable;

            if(permission_disable){
                return true;
            }else if(permit_code){

                if(permit_code == "permitted"){
                    return true;
                }else{

                    const permissions=this.$store.state.site.user_permissions;

                    if(permissions && permissions.length){

                        const userPermission = permissions.find(
                            (permission) => permission == permit_code
                        );

                        return userPermission == undefined ? false : true;

                    } else {
                        return false;
                    }
                }

            }else return false;
        },
        chunk: function (arr, len) {
            var chunks = [],
                i = 0,
                n = arr.length;

            while (i < n) {
                chunks.push(arr.slice(i, (i += len)));
            }

            return chunks;
        },
        getInitials(string) {
            var names = string.split(" "),
                initials = names[0].substring(0, 1).toUpperCase();

            if (names.length > 1) {
                initials += names[names.length - 1]
                    .substring(0, 1)
                    .toUpperCase();
            }
            return initials;
        },
        getStatuseByGroupCode: function (groupCode) {
            const statusGroups = this.dropdownList.statusGroups;
            if (statusGroups) {
                const screeningGroups = statusGroups.find(
                    (item) => item.code == groupCode
                );
                if (screeningGroups) {
                    if (
                        screeningGroups.statuses &&
                        screeningGroups.statuses.length
                    ) {
                        return screeningGroups.statuses;
                    } else {
                        return [];
                    }
                } else {
                    return [];
                }
            } else {
                return [];
            }
        },
        getStatuseByCode: function (codeValue) {
            const statusGroups = this.dropdownList.statusGroups;
            let statusObj = "";
            if (statusGroups && statusGroups.length) {
                statusGroups.forEach((group) => {
                    if (group.statuses && group.statuses.length) {
                        group.statuses.forEach((status) => {
                            if (status.code == codeValue) {
                                statusObj = status;
                            }
                        });
                    }
                });
            }
            return statusObj;
        },
        map_treeselect: function (list, id = "id", label = "name") {
            if (list && list.length) {
                return list.map((row) => {
                    return {
                        id: row[id],
                        label: row[label],
                    };
                });
            } else return [];
        },
        map_bv_select: function (list, id = "id", label = "name") {
            if (list && list.length) {
                return list.map((row) => {
                    return {
                        value: row[id],
                        text: row[label],
                    };
                });
            } else return [];
        },
        ageFullCount: function (startDate, defualtEndDate = new Date()) {
            const dob = new Date(startDate);
            const endDate = new Date(defualtEndDate);
            //extract the year, month, and date from user date input
            let dobYear = dob.getYear();
            let dobMonth = dob.getMonth();
            let dobDate = dob.getDate();

            //extract the year, month, and date from current date
            let currentYear = endDate.getYear();
            let currentMonth = endDate.getMonth();
            let currentDate = endDate.getDate();

            //get years
            let yearAge = currentYear - dobYear;
            let monthAge = "";

            //get months
            if (currentMonth >= dobMonth)
                //get months when current month is greater
                monthAge = currentMonth - dobMonth;
            else {
                yearAge--;
                monthAge = 12 + currentMonth - dobMonth;
            }
            let dateAge = "";
            //get days
            if (currentDate >= dobDate)
                //get days when the current date is greater
                dateAge = currentDate - dobDate;
            else {
                monthAge--;
                dateAge = 31 + currentDate - dobDate;

                if (monthAge < 0) {
                    monthAge = 11;
                    yearAge--;
                }
            }
            //group the age in a single variable
            let age = {
                years: yearAge,
                months: monthAge,
                days: dateAge,
            };

            let ageString = "";

            if (age.years > 0 && age.months > 0 && age.days > 0) {
                ageString =
                    age.years +
                    " Years " +
                    age.months +
                    " Months and " +
                    age.days +
                    " Days";
            } else if (age.years == 0 && age.months == 0 && age.days > 0) {
                ageString = "Only " + age.days + " Days!";
            }
            //when current month and date is same as birth date and month
            else if (age.years > 0 && age.months == 0 && age.days == 0) {
                ageString = age.years + "0 Day";
                console.log('ageString', ageString)
            } else if (age.years > 0 && age.months > 0 && age.days == 0) {
                ageString = age.years + " Years and " + age.months + " Months.";
            } else if (age.years == 0 && age.months > 0 && age.days > 0) {
                ageString = age.months + " Months and " + age.days + " Days";
            } else if (age.years > 0 && age.months == 0 && age.days > 0) {
                ageString = age.years + " Years and " + age.days + " Days";
            } else if (age.years == 0 && age.months > 0 && age.days == 0) {
                ageString = age.months + " Months.";
            }
            //when current date is same as dob(date of birth)
            // else ageString = "Welcome to Earth! <br> It's first day on Earth!";
            else ageString = "0 Day";

            return ageString;
        },
        dayMonthYearCount: function (startDate, defualtEndDate = new Date()) {
            const dob = new Date(startDate);
            const endDate = new Date(defualtEndDate);
            //extract the year, month, and date from user date input
            let dobYear = dob.getYear();
            let dobMonth = dob.getMonth();
            let dobDate = dob.getDate();

            //extract the year, month, and date from current date
            let currentYear = endDate.getYear();
            let currentMonth = endDate.getMonth();
            let currentDate = endDate.getDate();

            //get years
            let yearAge = currentYear - dobYear;
            let monthAge = "";

            //get months
            if (currentMonth >= dobMonth)
                //get months when current month is greater
                monthAge = currentMonth - dobMonth;
            else {
                yearAge--;
                monthAge = 12 + currentMonth - dobMonth;
            }
            let dateAge = "";
            //get days
            if (currentDate >= dobDate)
                //get days when the current date is greater
                dateAge = currentDate - dobDate + 1;
            else {
                monthAge--;
                dateAge = 31 + currentDate - dobDate;

                if (monthAge < 0) {
                    monthAge = 11;
                    yearAge--;
                }
            }
            //group the age in a single variable
            let age = {
                years: yearAge,
                months: monthAge,
                days: dateAge,
            };

            let ageString = "";

            if (age.years > 0 && age.months > 0 && age.days > 0) {
                ageString =
                    age.years +
                    " Years " +
                    age.months +
                    " Months and " +
                    age.days +
                    " Days";
            } else if (age.years == 0 && age.months == 0 && age.days > 0) {
                ageString = "Only " + age.days + " Days!";
            }
            //when current month and date is same as birth date and month
            else if (age.years > 0 && age.months == 0 && age.days == 0) {
                ageString = age.years + "0 Day";
                console.log('ageString', ageString)
            } else if (age.years > 0 && age.months > 0 && age.days == 0) {
                ageString = age.years + " Years and " + age.months + " Months.";
            } else if (age.years == 0 && age.months > 0 && age.days > 0) {
                ageString = age.months + " Months and " + age.days + " Days";
            } else if (age.years > 0 && age.months == 0 && age.days > 0) {
                ageString = age.years + " Years and " + age.days + " Days";
            } else if (age.years == 0 && age.months > 0 && age.days == 0) {
                ageString = age.months + " Months.";
            }
            //when current date is same as dob(date of birth)
            // else ageString = "Welcome to Earth! <br> It's first day on Earth!";
            else ageString = "0 Day";

            return ageString;
        },
        go_to: function (uri) {
            return this.$router.push(uri);
        },
        fDate: function (dt) {
            return moment.utc(dt).local().format("DD MMM YYYY");
        },
        fTime: function (dt) {
            return moment.utc(dt).local().format("HH:mm:ss");
        },
        getCommonDropdownList: async function () {

            let ref = this;
            let url = `${this.base_url}/api/v1/get_common_dropdown_list`;
            let jq = ref.jq();

            try {
                let res = await jq.get(url);
                this.$store.commit('setDropdowns', res.data);
            } catch (error) {
                this.alert(ref.err_msg(error), 'error')
            }
        },
        getBase64ImageFromURL(url) {
            return new Promise((resolve, reject) => {
                var img = new Image();
                img.setAttribute("crossOrigin", "anonymous");

                img.onload = () => {
                    var canvas = document.createElement("canvas");
                    canvas.width = img.width;
                    canvas.height = img.height;

                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0);

                    var dataURL = canvas.toDataURL("image/png");

                    resolve(dataURL);
                };

                img.onerror = (error) => {
                    reject(error);
                };

                img.src = url;
            });
        },
        pagination_str: function(data){
            //console.log(data);
            if(data){
                let from=(data.per_page * (data.current_page - 1))+1;
                let to=(data.per_page * data.current_page);
                let entries=data.total;

                if(to > data.total){
                    to=data.total;
                }

                if(data.total==0){
                    from=0;
                }

                return `Showing ${from} to ${to} of ${entries} entries`;

            }else return "";
        },
        page_sl: function(pData, index){
            return (pData.per_page * (pData.current_page - 1)) + (index+1);
        },
        getAuthUserInfo: async function () {

            var ref=this;
            var jq=ref.jq();

            try{

            var res=await jq.get(ref.apiUrl('api/v1/client/auth-user'));

            ref.$store.commit('siteInfo', {
                key: 'auth_user',
                val: res.data.auth_user
            });

            ref.$store.commit('siteInfo', {
                key: 'company',
                val: res.data.company
            });

            ref.$store.commit('siteInfo', {
                key: 'user_permissions',
                val: res.data.user_permissions
            });

            }catch(err){
                localStorage.removeItem('api_token');
                ref.$router.push('/login');
            }
        }
    }, //End of method
};
