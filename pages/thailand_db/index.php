<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>thailand_db</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(function() {
            let endpoint = "http://localhost/php-components/api/";
            let loading = false;
            let offset = 0;

            const limit = 10; 

            function loadProvinces() {
                if (loading) return;
                loading = true;

                $.ajax({
                    type: "POST",
                    url: endpoint + "thailand_db/action.php",
                    data: {
                        get_provinces: "get_provinces"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.data.length > 0) {
                            let select = `<option value="0" selected>Select province</option>`;
                            response.data.forEach((province) => {
                                select += `<option value="${province.id}">${province.name_in_thai}</option>`;
                            });
                            $("#provinces").html(select);
                            offset += limit;
                        }
                        loading = false;
                    }
                });
            }

            function loadDistricts(provinceId) {
                $.ajax({
                    type: "POST",
                    url: endpoint + "thailand_db/action.php",
                    data: {
                        get_districts: "get_districts",
                        province_id: provinceId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.data.length > 0) {
                            let select = `<option value="0" selected>Select district</option>`;
                            response.data.forEach((district) => {
                                select += `<option value="${district.id}">${district.name_in_thai}</option>`;
                            });
                            $("#districts").html(select);
                        } else {
                            $("#districts").html('<option value="0" selected>Select district</option>');
                        }
                    }
                });
            }

            function loadSubdistricts(districtId) {
                $.ajax({
                    type: "POST",
                    url: endpoint + "thailand_db/action.php",
                    data: {
                        get_subdistricts: "get_subdistricts",
                        district_id: districtId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.data.length > 0) {
                            let select = `<option value="0" selected>Select subdistrict</option>`;
                            response.data.forEach((subdistrict) => {
                                select += `<option value="${subdistrict.id}">${subdistrict.name_in_thai}</option>`;
                            });
                            $("#subdistricts").html(select);
                        } else {
                            $("#subdistricts").html('<option value="0" selected>Select subdistrict</option>');
                        }
                    }
                });
            }

            $(window).on("scroll", function() {
                if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                    loadProvinces();
                }
            });

            loadProvinces();

            $("#provinces").change(function() {
                let provinceId = $(this).val();
                if (provinceId > 0) {
                    loadDistricts(provinceId);
                    $("#districts").html('<option value="0" selected>Select district</option>');
                    $("#subdistricts").html('<option value="0" selected>Select subdistrict</option>');
                } else {
                    $("#districts").html('<option value="0" selected>Select district</option>');
                    $("#subdistricts").html('<option value="0" selected>Select subdistrict</option>');
                }
            });

            $("#districts").change(function() {
                let districtId = $(this).val();
                if (districtId > 0) {
                    loadSubdistricts(districtId);
                } else {
                    $("#subdistricts").html('<option value="0" selected>Select subdistrict</option>');
                }
            });
        });
    </script>

    <style>
        .scrollable-select {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>

</head>

<body>
    <div class="container mt-4">
        <select class="form-select scrollable-select" id="provinces">
            <option value="0" selected>Select province</option>
        </select>
        <br>
        <select class="form-select" id="districts">
            <option value="0" selected>Select district</option>
        </select>
        <br>
        <select class="form-select" id="subdistricts">
            <option value="0" selected>Select subdistrict</option>
        </select>
    </div>
</body>

</html>