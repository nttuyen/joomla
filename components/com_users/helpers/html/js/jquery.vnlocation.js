//jQueryPlugin
(function($){
    $.fn.vnlocation = function(setting) {
        var settings = $.extend($.fn.vnlocation.defaults, setting);
        $.fn.vnlocation.province(settings);
    }
    
    $.fn.vnlocation.province = function(settings) {
        if(settings.province == '') {
            return;
        }
        var currentProvince = settings.current_province;
        var $obj = $(settings.province);
        var $html = "<option value=\"\">Chọn tỉnh/thành phố</option>" + "\n";
        $.each($.fn.vnlocation.provincedata, function(key, value){
            $html += "<option value=\"" + value + "\"";
            if(value == currentProvince) {
                $html += "selected = \"selected\"";
            }
            $html += ">" + value + "</option>" + "\n";
        });
        $obj.html($html);
        
        if(settings.district != '') {
            $obj.change(function(){
                var $cityOption = $.fn.vnlocation.districtdata($(this).val());
                var currentDistrict = settings.current_district;
                var $cityHtml = "<option value=\"\">Chọn quận/huyện</option>" + "\n";
                $.each($cityOption, function(key, value) {
                    $cityHtml += "<option value=\""+value+"\"";
                    if(value == currentDistrict) {
                        $cityHtml += "selected = \"selected\"";
                    }
                    $cityHtml += ">"+value+"</option>" + "\n";
                });
                $(settings.district).html($cityHtml);
            });
        }
        if(currentProvince != '') {
            $obj.change();
        }
    }
    
    $.fn.vnlocation.defaults = {
        province: "",
        district: "",
        village: ""
    };
    $.fn.vnlocation.provincedata = new Array(
        "Hà Nội","Tp Hồ Chí Minh","An Giang","Bà Rịa - Vũng Tàu","Bình Dương","Bình Phước","Bình Thuận","Bình Định","Bạc Liêu","Bắc Giang","Bắc Kạn","Bắc Ninh","Bến Tre","Cao Bằng","Cà Mau","Cần Thơ","Gia Lai","Hà Giang","Đồng Tháp","Đồng Nai","Điện Biên","Đắk Nông","Đà Nẵng","Đaklak","Hà Nam","Hà Tĩnh","Hải Dương","Tp.Hải Phòng","Hậu Giang","Hoà Bình","Hưng Yên","Khánh Hoà","Kiên Giang","Kon Tum","Lai Châu","Lạng Sơn","Lào Cai","Lâm Đồng","Long An","Nam Định","Nghệ An","Ninh Bình","Ninh Thuận","Phú Thọ","Phú Yên","Quảng Bình","Quảng Nam","Quảng Ngãi","Quảng Ninh","Quảng Trị","Sóc Trăng","Sơn La","Tây Ninh","Thanh Hoá","Thái Bình","Thái Nguyên","Thừa Thiên Huế","Tiền Giang","Trà Vinh","Tuyên Quang","Vĩnh Long","Vĩnh Phúc","Yên Bái"
    );
    $.fn.vnlocation.districtdata = function(province) {
        var cityOptions = new Array();
        switch (province) {
                case "Hà Nội":
                    cityOptions = new Array(
                    "Ba Đình",
                    "Cầu Giấy",
                    "Đống Đa",
                    "Hoàn Kiếm",
                    "Hai Bà Trưng",
                    "Hà Đông",
                    "Hoàng Mai",
                    "Long Biên",
                    "Tây Hồ",
                    "Thanh Xuân",
                    "Ba Vì",
                    "Đông Anh",
                    "Gia Lâm",
                    "Từ Liêm",
                    "Thanh Trì",
                    "Sóc Sơn",
                    "Phúc Thọ",
                    "Thạch Thất",
                    "Đan Phượng",
                    "Quốc Oai",
                    "Hoài Đức",
                    "Thường Tín",
                    "Phú Xuyên",
                    "Thanh Oai",
                    "Chương Mỹ",
                    "Mỹ Đức",
                    "Ứng Hòa",
                    "Tp.Sơn Tây");
                    break;
                case "Tp Hồ Chí Minh":
                    cityOptions = new Array(
                    "Quận 1",
                    "Quận 2",
                    "Quận 3",
                    "Quận 4",
                    "Quận 5",
                    "Quận 6",
                    "Quận 7",
                    "Quận 8",
                    "Quận 9",
                    "Quận 10",
                    "Quận 11",
                    "Quận 12",
                    "Bình Tân",
                    "Bình Thạnh",
                    "Gò Vấp",
                    "Phú Nhuận",
                    "Tân Bình",
                    "Tân Phú",
                    "Thủ Đức",
                    "Huyện Nhà Bè",
                    "Huyện Hóc Môn",
                    "Huyện Củ Chi",
                    "Huyện Cần Giờ",
                    "Huyện Bình Chánh");
                    break;
                case "An Giang" :
                    cityOptions = new Array(
                    "Long Xuyên",
                    "Châu Đốc",
                    "Chợ Mới",
                    "Phú Tân",
                    "Tân Châu",
                    "An Phú",
                    "Tri Tôn",
                    "Tịnh Biên",
                    "Châu Thành",
                    "Châu Phú",
                    "Thoại Sơn");
                     break;
                case "Bà Rịa - Vũng Tàu" :
                    cityOptions = new Array(
                     "Tp.Vũng Tàu",
                     "Thị xã Bà Rịa",
                     "Huyện Châu Đức",
                     "Huyện Côn Đảo",
                     "Huyện Long Điền",
                     "Huyện Đất Đỏ",
                     "Huyện Tân Thành",
                     "Huyện Xuyên Mộc");
                    break;			
                case "Bình Dương":
                    cityOptions = new Array(
                    "Bến Cát",
                    "Dầu Tiếng",
                    "Dĩ An",
                    "Phú Giáo",
                    "Tân Uyên",
                    "Thuận An",
                    "Thủ Dầu Một");
                    break;		
                case "Bình Phước":
                    cityOptions = new Array(
                    "Đồng Xoài",
                    "Đồng Phù",
                    "Phước Long",
                    "Lộc Ninh",
                    "Bù Đăng",
                    "Bình Long",
                    "Bù Đốp",
                    "Chơn Thành");
                    break;
                case "Bình Thuận":
                    cityOptions = new Array(
                    "Hàm Thuận Bắc",
                    "Tánh Linh",
                    "Tuy phong",
                    "Hàm Thuận Nam");
                    break;
                case "Bình Định":
                    cityOptions = new Array(
                    "TP Quy Nhơn",
                    "An Lão",
                    "Vĩnh Thạnh",
                    "Vân Canh",
                    "Hoài Ân",
                    "Hoài Nhơn",
                    "Phù Mỹ",
                    "Phù Cát",
                    "Tây Sơn",
                    "An Nhơn",
                    "Tuy Phước");
                    break;
                case "Bạc Liêu":
                    cityOptions = new Array(
                    "Bạc Liêu",
                    "Hoà Bình",
                    "Đông Hải",
                    "Giá Rai",
                    "Hông Dân",
                    "Phước Long",
                    "Vĩnh Lợi");
                    break;
                case "Bắc Giang":
                    cityOptions = new Array(
                    "TP Bắc Giang",
                    "Lạng Giang",
                    "Hiệp Hoà",
                    "Việt Yên",
                    "Yên Dũng",
                    "Tân Yên",
                    "Lục Nam",
                    "Lục Ngạn",
                    "Sơn Động",
                    "Yên Thế");
                    break;
                case "Bắc Kạn":
                    cityOptions = new Array(
                    "Thị xã Bắc Kạn",
                    "Pác Nặm ",
                    "Chợ Đồn",
                    "Chợ Mới",
                    "Bạch Thông",
                    "Na Rì",
                    "Ngân Sơn",
                    "Ba Bể");
                    break;
                case "Bắc Ninh":
                    cityOptions = new Array(
                    "Thị xã Bắc Ninh",
                    "Gia Bình",
                    "Lương Tài",
                    "Quế Võ",
                    "Yên Phong",
                    "Thuận Thành",
                    "Tiên Du",
                    "Từ Sơn");
                    break;
                case "Bến Tre":
                    cityOptions = new Array(
                    "Thị xã Bến Tre ",
                    "Châu Thành",
                    "Chợ Lách",
                    "Bình Đại",
                    "Giồng Trôm",
                    "Mỏ Cày",
                    "Ba Tri",
                    "Thạnh Phú");
                    break;
                case "Cao Bằng":
                    cityOptions = new Array(
                    "Thị Xã Cao Bằng",
                    "Hoà An",
                    "Quảng Uyên",
                    "Phục Hoà",
                    "Trà Linh",
                    "Thạch An",
                    "Nguyên Bình",
                    "Bảo Lạc",
                    "Bảo Lâm",
                    "Trùng Khánh");
                    break;
                case "Cà Mau":
                    cityOptions = new Array(
                    "Tp Cà Mau",
                    "Đầm Dơi",
                    "Thới Bình",
                    "Trần Văn Thời",
                    "Năm Căn",
                    "Ngọc Hiến",
                    "Phú Tân",
                    "Cái Nước",
                    "U Minh");
                    break;
                case "Cần Thơ":
                    cityOptions = new Array(
                    "Ninh Kiều ",
                    "Bình Thủy",
                    "Cái Răng",
                    "Ô Môn",
                    "Phong Điền",
                    "Cờ Đỏ",
                    "Vĩnh Thạnh",
                    "Thốt Nốt");
                    break;
                case "Gia Lai":
                    cityOptions = new Array(
                    "Tp Pleiku",
                    "An Khê",
                    "Ayun Pa",
                    "Đăk Pơ",
                    "Đăk Đoa",
                    "A Yun Pa",
                    "Chư Păh",
                    "Chư Prông",
                    "Chư Sê",
                    "Đức Cơ",
                    "Ia Grai",
                    "Kbang",
                    "Krông Pa",
                    "Kông Chro",
                    "Mang Yang",
                    "Ia Pa",
                    "Phú Thiện");
                    break;
                case "Hà Giang":
                    cityOptions = new Array(
                    "Thị xã Hà Giang",
                    "Bắc Mê",
                    "Đồng Văn",
                    "Hoàng Su Phì",
                    "Mèo Vạc",
                    "Quang Bình",
                    "Quản Bạ",
                    "Vị Xuyên",
                    "Xín Mần",
                    "Yên Minh",
                    "Bắc Quang");
                    break;
                case "Đồng Tháp":
                    cityOptions = new Array(
                    "Thành phố Cao Lãnh",
                    "Thị xã Sa Đéc",
                    "Tháp Mười",
                    "Thanh Bình",
                    "Tân Hồng",
                    "Tam Nông",
                    "Lấp Vò",
                    "Lai Vung",
                    "Hồng Ngự",
                    "Châu Thành",
                    "Huyện Cao Lãnh");
                    break;
                case "Đồng Nai":
                    cityOptions = new Array(
                    "Tp Biên Hòa",
                    "Long Khánh",
                    "Long Thành",
                    "Nhơn Trạch",
                    "Trảng Bom",
                    "Thống Nhất",
                    "Cẩm Mỹ",
                    "Vĩnh Cửu",
                    "Xuân Lộc",
                    "Định Quán",
                    "Tân Phú");
                    break;
                case "Điện Biên":
                    cityOptions = new Array(
                    "Tp Điện Biên Phủ",
                    "Điện Biên",
                    "Điện Biên Đông",
                    "Mường Ảng",
                    "Mường Chà",
                    "Mường Nhé",
                    "Tủa Chùa",
                    "Tuần Giáo");
                    break;
                case "Đắk Nông":
                    cityOptions = new Array(
                    "Thị xã Gia Nghĩa",
                    "Cư Jút",
                    "Đăk Glong",
                    "Đăk Mil",
                    "Đăk R'Lấp",
                    "Đăk Song",
                    "Krông Nô",
                    "Tuy Đức");
                    break;
                case "Đà Nẵng":
                    cityOptions = new Array(
                    "Hải Châu",
                    "hanh Khê",
                    "Liên Chiểu",
                    "Sơn Trà",
                    "Cẩm Lệ",
                    "Ngũ Hành Sơn",
                    "Hòa Vang",
                    "Hoàng Sa");
                    break;
                case "Đaklak":
                    cityOptions = new Array(
                    "Tp Buôn Ma Thuột",
                    "Krông Buk",
                    "Krông Pak",
                    "Lắk",
                    "Ea Súp",
                    "M'Drăk",
                    "Krông Ana",
                    "Krông Bông",
                    "Ea H'leo",
                    "Cư M'gar",
                    "Krông Năng",
                    "Buôn Đôn",
                    "Ea Kar",
                    "Cư Kuin");
                    break;
                case "Hà Nam":
                    cityOptions = new Array(
                    "Tp Phủ Lý",
                    "Bình Lục",
                    "Duy Tiên",
                    "Kim Bảng",
                    "ý Nhân",
                    "Thanh Liêm");
                    break;
                case "Hà Tĩnh":
                    cityOptions = new Array(
                    "Tp Hà Tĩnh",
                    "Thị xã Hồng Lĩnh",
                    "Kỳ Anh",
                    "Lộc Hà",
                    "Thạch Hà",
                    "Can Lộc",
                    "Nghi Xuân",
                    "Đức Thọ",
                    "Hương Sơn",			
                    "Vũ Quang",
                    "Cẩm Xuyên");
                    break;
                case "Hải Dương":
                    cityOptions = new Array(
                    "Tp Hải Dương",
                    "Chí Linh",
                    "Nam Sách",
                    "Kinh Môn",
                    "Kim Thành",
                    "Thanh Hà",
                    "Ninh Giang",
                    "Gia Lộc",
                    "Tứ Kỳ",
                    "Thanh Miện",
                    "Cẩm Giàng",
                    "Bình Giang");
                    break;
                case "Tp.Hải Phòng":
                    cityOptions = new Array(
                    "Dương Kinh",
                    "Đồ Sơn",
                    "Hải An",
                    "Hồng Bàng",
                    "Kiến An",
                    "Lê Chân",
                    "Ngô Quyền",
                    "An Dương",
                    "An Lão",
                    "Bạch Long Vĩ",
                    "Cát Hải",
                    "Kiến Thụy",
                    "Thủy Nguyên",
                    "Tiên Lãng",
                    "Vĩnh Bảo");
                    break;
                case "Hậu Giang":
                    cityOptions = new Array(
                    "Thị xã Vị Thanh",
                    "Thị xã Ngã Bảy",
                    "Long Mỹ",
                    "Phụng Hiệp",
                    "Châu Thành",
                    "Châu Thành A");
                    break;
                case "Hoà Bình":
                    cityOptions = new Array(
                    "Thị xã Hoà Bình",
                    "Cao Phong",
                    "Lương Sơn",
                    "Kỳ Sơn",
                    "Kim Bôi",
                    "Lạc Thuỷ",
                    "Yên Thủy",
                    "Đà Bắc",
                    "Mai Châu");
                    break;
                case "Hưng Yên":
                    cityOptions = new Array(
                    "Thị xã Hưng Yên",
                    "Ân Thi",
                    "Khoái Châu",
                    "Kim Động",
                    "Mỹ Hào",
                    "Phù Cừ",
                    "Tiên Lữ",
                    "Văn Giang",
                    "Văn Lâm",
                    "Yên Mỹ");
                    break;
                case "Khánh Hoà":
                    cityOptions = new Array(
                    "Tp Nha Trang",
                    "Thị xã Cam Ranh",
                    "Ninh Hòa",
                    "Diên Khánh",
                    "Vạn Ninh",
                    "Cam Lâm",
                    "Khánh Sơn",
                    "Khánh Vĩnh",
                    "Trường Sa");
                    break;
                case "Kiên Giang":
                    cityOptions = new Array(
                    "Tp. Rạch Giá ",
                    "Thị xã Hà Tiên",
                    "An Biên",
                    "An Minh",
                    "Kiên Lương",
                    "Hòn Đất",
                    "Tân Hiệp",
                    "Châu Thành",
                    "Giồng Riềng",
                    "Gò Quao",
                    "Vĩnh Thuận",
                    "Phú Quốc",
                    "Kiên Hải",
                    "U Minh Thượng");
                    break;
                case "Kon Tum":
                    cityOptions = new Array(
                    "Thị xã Kontum",
                    "Đak Hà",
                    "Đăk Tô",
                    "Ngọc Hồi",
                    "Đăk Glei",
                    "Sa Thầy",
                    "Kon Rẩy",
                    "Kon Plong",
                    "TuMơRông");
                    break;
                case "Lai Châu":
                    cityOptions = new Array(
                    "Thị xã Lai Châu",
                    "Mường Tè",
                    "Phong Thổ",
                    "Sìn Hồ",
                    "Tam Đường",
                    "Than Uyên");
                    break;
                case "Lạng Sơn":
                    cityOptions = new Array(
                    "Tràng Định",
                    "Văn Lãng",
                    "Văn Quan",
                    "Bình Gia",
                    "Bắc Sơn",
                    "Chi Lăng",
                    "Cao Lộc",
                    "Lộc Bình",
                    "Đình Lập",
                    "Hữu Lũng");
                    break;
                case "Lào Cai":
                    cityOptions = new Array(
                    "TP Lào Cai",
                    "Bát Xát",
                    "Bắc Hà",
                    "Bảo Yên",
                    "Mường Khương",
                    "Si Ma Cai",
                    "Sa Pa",
                    "Văn Bàn");
                    break;
                case "Lâm Đồng":
                    cityOptions = new Array(
                    "Tp Đà Lạt",
                    "Thị xã Bảo Lộc",
                    "Lạc Dương",
                    "Đơn Dương",
                    "Đức Trọng",
                    "Lâm Hà",
                    "Di Linh",
                    "Bảo Lâm",
                    "Đạ Huoai",
                    "Đạ Tẻh",
                    "Cát Tiên",
                    "Đam Rôn");
                    break;
                case "Long An":
                    cityOptions = new Array(
                    "Thị xã Tân An",
                    "Bến Lức",
                    "Cần Đước",
                    "Cần Giuộc",
                    "Châu Thành",
                    "Đức Hòa",
                    "Đức Huệ",
                    "Mộc Hóa",
                    "Tân Hưng",
                    "Tân Thạnh",
                    "Tân Trụ",
                    "Thạnh Hóa",
                    "Thủ Thừa",
                    "Vĩnh Hưng");
                    break;
                case "Nam Định":
                    cityOptions = new Array(
                    "Tp. Nam Định",
                    "Hải Hậu",
                    "Mỹ Lộc",
                    "Vụ Bản",
                    "Giao Thuỷ",
                    "Ý Yên",
                    "Nam Trực",
                    "Trực Ninh",
                    "Nghĩa Hưng",
                    "Xuân Trường");
                    break;
                case "Nghệ An":
                    cityOptions = new Array(
                    "Thị xã Thái Hòa",										
                    "Tp. Vinh",
                    "Thị xã Cửa Lò",
                    "Anh Sơn",
                    "Diễn Châu",
                    "Con Cuông",
                    "Quỳnh Lưu",
                    "Nam Đàn",
                    "Đô Lương",
                    "Hưng Nguyên",
                    "Nghi Lộc",
                    "Quế Phong",
                    "Quỳ Hợp",
                    "Thanh Chương",
                    "Tương Dương",
                    "Kỳ Sơn",
                    "Nghĩa Đàn",
                    "Quỳ Châu",
                    "Tân Kỳ",
                    "Yên Thành");
                    break;
                case "Ninh Bình":
                    cityOptions = new Array(
                    "Tp Ninh Bình",
                    "Thị xã Tam Điệp",
                    "Gia Viễn",
                    "Hoa Lư",
                    "Kim Sơn",
                    "Nho Quan",
                    "Yên Khánh",
                    "Yên Mô");
                    break;
                case "Ninh Thuận":
                    cityOptions = new Array(
                    "Tp Phan Rang-Tháp Chàm",
                    "Bác Ái",
                    "Ninh Hải",
                    "Ninh Phước",
                    "Ninh Sơn",
                    "Thuận Bắc");
                    break;
                case "Phú Thọ":
                    cityOptions = new Array(
                    "Tp Việt Trì",
                    "Thị xã Phú Thọ",
                    "Cẩm Khê",
                    "Đoan Hùng",
                    "Hạ Hòa",
                    "Lâm Thao",
                    "Phù Ninh",
                    "Tam Nông",
                    "Tân Sơn",
                    "Thanh Ba",
                    "Thanh Sơn",
                    "Thanh Thủy",
                    "Yên Lập");
                    break;
                case "Phú Yên":
                    cityOptions = new Array(
                    "Tp Tuy Hòa",
                    "Đông Hòa",
                    "Đồng Xuân",
                    "Phú Hòa",
                    "Sơn Hòa",
                    "Sông Cầu",
                    "Sông Hinh",
                    "Tây Hòa",
                    "Tuy An");
                    break;
                case "Quảng Bình":
                    cityOptions = new Array(
                    "Tp Đồng Hới",
                    "Bố Trạch",
                    "Lệ Thủy",
                    "Minh Hóa",
                    "Quảng Trạch",
                    "Quảng Ninh",
                    "Tuyên Hóa");
                    break;
                case "Quảng Nam":
                    cityOptions = new Array(
                    "Tp Tam Kỳ",
                    "Tp Hội An",
                    "Duy Xuyên",
                    "Đại Lộc",
                    "Điện Bàn",
                    "Đông Giang",
                    "Nam Giang",
                    "Tây Giang",
                    "Quế Sơn",
                    "Hiệp Đức",
                    "Núi Thành",
                    "Nam Trà My",
                    "Bắc Trà My",
                    "Phú Ninh",
                    "Phước Sơn",
                    "Thăng Bình",
                    "Tiên Phước",
                    "Nông Sơn");
                    break;
                case "Quảng Ngãi":
                    cityOptions = new Array(
                    "Tp Quảng Ngãi",
                    "Ba Tơ",
                    "Bình Sơn",
                    "Đức Phổ",
                    "Minh Long",
                    "Mộ Đức",
                    "Sơn Hà",
                    "Sơn Tây",
                    "Sơn Tịnh",
                    "Tây Trà",
                    "Trà Bồng",
                    "Tư Nghĩa",
                    "Lý Sơn");
                    break;
                case "Quảng Ninh":
                    cityOptions = new Array(
                    "Tp Hạ Long",
                    "Thị xã Cẩm Phả",
                    "Thị xã Móng Cái",
                    "Thị xã Uông Bí",
                    "Ba Chẽ",
                    "Bình Liêu",
                    "Đầm Hà",
                    "Đông Triều",
                    "Hải Hà",
                    "Hoành Bồ",
                    "Tiên Yên",
                    "Vân Đồn",
                    "Yên Hưng");
                    break;
                case "Quảng Trị":
                    cityOptions = new Array(
                    "Thị xã Đông Hà",
                    "Thị xã Quảng Trị",
                    "Cam Lộ",
                    "Cồn Cỏ",
                    "Đa Krông",
                    "Gio Linh",
                    "Hải Lăng",
                    "Hướng Hóa",
                    "Triệu Phong",
                    "Vĩnh Linh");
                    break;
                case "Sóc Trăng":
                    cityOptions = new Array(
                    "Tp Sóc Trăng",
                    "Long Phú",
                    "Cù Lao Dung",
                    " Mỹ Tú",
                    "Thạnh Trị",
                    "Vĩnh Châu",
                    "Ngã Năm",
                    "Kế Sách",
                    "Mỹ Xuyên");
                    break;
                case "Sơn La":
                    cityOptions = new Array(
                    "Tp Sơn La",
                    "Quỳnh Nhai",
                    "Mường La",
                    "Thuận Châu",
                    "Phù Yên",
                    "Bắc Yên",
                    "Mai Sơn",
                    "Sông Mã",
                    "Yên Châu",
                    "Mộc Châu",
                    "Sốp Cộp");
                    break;
                case "Tây Ninh":
                    cityOptions = new Array(
                    "Thị xã Tây Ninh",
                    "Tân Biên",
                    "Tân Châu",
                    "Dương Minh Châu",
                    "Châu Thành",
                    "Hòa Thành",
                    "Bến Cầu",
                    "Gò Dầu",
                    "Trảng Bàng");
                    break;
                case "Thanh Hoá":
                    cityOptions = new Array(
                    "Tp Thanh Hóa",
                    "Thị xã Bỉm Sơn",
                    "Thị xã Sầm Sơn",
                    "Bá Thước",
                    "Cẩm Thủy",
                    "Đông Sơn",
                    "Hà Trung",
                    "Hậu Lộc",
                    "Hoằng Hóa",
                    "Lang Chánh",
                    "Mường Lát",
                    "Nga Sơn",
                    "Ngọc Lặc",
                    "Như Thanh",
                    "Như Xuân",
                    "Nông Cống",
                    "Quan Hóa",
                    "Quan Sơn",
                    "Quảng Xương",
                    "Thạch Thành",
                    "Thiệu Hóa",
                    "Thọ Xuân",
                    "Thường Xuân",
                    "Tĩnh Gia",
                    "Triệu Sơn",
                    "Vĩnh Lộc",
                    "Yên Định");
                    break;
                case "Thái Bình":
                    cityOptions = new Array(
                    "Tp Thái Bình",
                    "Thái Thuỵ",
                    "Tiền Hải",
                    "Đông Hưng",
                    "Vũ Thư",
                    "Kiến Xương",
                    "Quỳnh Phụ",
                    "Hưng Hà");
                    break;
                case "Thái Nguyên":
                    cityOptions = new Array(
                    "Tp Thái Nguyên",
                    "Thị xã Sông Công",
                    "Phổ Yên",
                    "Phú Bình",
                    " Đồng Hỷ",
                    "Võ Nhai",
                    "Định Hóa",
                    "Đại Từ",
                    "Phú Lương");
                    break;
                case "Thừa Thiên Huế":
                    cityOptions = new Array(
                    "Thành phố Huế",
                    "A Lưới",
                    "Phú Lộc",
                    "Hương Thủy",
                    "Phú Vang",
                    "Hương Trà",
                    "Quảng Điền",
                    "Nam Đông");
                    break;
                case "Tiền Giang":
                    cityOptions = new Array(
                    "Tp Mỹ Tho",
                    "Thị xã Gò Công",
                    "Cái Bè",
                    "Cai Lậy",
                    "Châu Thành",
                    "Tân Phước",
                    "Chợ Gạo",
                    "Gò Công Tây",
                    "Gò Công Đông",
                    "Tân Phú Đông");
                    break;
                case "Trà Vinh":
                    cityOptions = new Array(
                    "Thị xã Trà Vinh",
                    "Trà Cú",
                    "Duyên Hải",
                    "Cầu Ngang",
                    "Châu Thành",
                    "Cầu Kè",
                    "Tiểu Cần",
                    "Càng Long ");
                    break;
                case "Tuyên Quang":
                    cityOptions = new Array(
                    "Thị xã Tuyên Quang ",
                    "Na Hang ",
                    "Chiêm Hoá",
                    "Hàm Yên ",
                    "Yên Sơn ",
                    "Sơn Dương ");
                    break;
                case "Vĩnh Long":
                    cityOptions = new Array(
                    "Thị xã Vĩnh Long",
                    "Long Hồ",
                    "Mang Thít",
                    "Tam Bình",
                    "Bình Minh",
                    "Vũng Liêm",
                    "Trà Ôn");
                    break;
                case "Vĩnh Phúc":
                    cityOptions = new Array(
                    "Tp Vĩnh Yên",
                    "Thị xã Phúc Yên",
                    "Vĩnh Tường",
                    "Bình Xuyên",
                    "Yên Lạc",
                    "Tam Dương",
                    "Tam Đảo ",
                    "Lập Thạch");
                    break;
                case "Yên Bái":
                    cityOptions = new Array(
                    "Tp Yên Bái",
                    "Thị xã Nghĩa Lộ",
                    "Lục Yên",
                    "Mù Cang Chải",
                    "Trấn Yên",
                    "Trạm Tấu",
                    "Văn Chấn",
                    "Văn Yên",
                    "Yên Bình");
                    break;
        }
        return cityOptions;
    }
})(jQuery);

