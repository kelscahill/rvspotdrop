/* --------------------- GET ALL COUNTRIES ------------------------ */
jQuery(function($) {
  jQuery.ajax({
    url: tc_csca_wp_auto_ajax.ajax_url,
    type: 'post',
    dataType: "json",
    data: {
      action: "csca_wp_countries",
      nonce_ajax: tc_csca_wp_auto_ajax.nonce
    },
    success: function(response) {
      // console.log(response);
      for (i = 0; i < response.length; i++) {
        var ct_id = response[i]['id'];
        var ct_name = response[i]['name'];
        var opt = "<option data-id='" + ct_id + "' value='" + ct_name + "'>" + ct_name + "</option>";
        $(".csca_wp_country select").append(opt);
      }
    }
  });

  jQuery.ajax({
    url: tc_csca_wp_auto_ajax.ajax_url,
    type: 'post',
    dataType: "json",
    data: {
      action: "csca_wp_countries",
      nonce_ajax: tc_csca_wp_auto_ajax.nonce
    },
    success: function(response) {
      // console.log(response);
      for (i = 0; i < response.length; i++) {
        var ct_id = response[i]['id'];
        var ct_name = response[i]['name'];
        var opt = "<option data-id='" + ct_id + "' value='" + ct_name + "'>" + ct_name + "</option>";
        $(".csca_wp_country_1 select").append(opt);
        $(".csca_wp_states_1 select").html('<option value="Select State" selected>Select State</option>');
        $(".csca_wp_cities_1 select").html('<option value="Select City" selected>Select City</option>');
      }
    }
  });

  $(".csca_wp_country select").change(function() {
    if ($(".csca_wp_states select").length > 0) {
      var cnt = $(this).children("option:selected").attr('data-id');
      var sel_state = $(".csca_wp_states select").val();
      var sel_city = '';
      var sel_city = $(".csca_wp_cities select").val();
      $(".csca_wp_states select").html('<option value="' + sel_state + '">' + sel_state + '</option>');
      $(".csca_wp_cities select").html('<option value="' + sel_city + '">' + sel_city + '</option>');
      jQuery.ajax({
        url: tc_csca_wp_auto_ajax.ajax_url,
        type: 'post',
        dataType: "json",
        data: {
          action: "csca_wp_states",
          nonce_ajax: tc_csca_wp_auto_ajax.nonce,
          cnt: cnt
        },
        success: function(response) {
          for (i = 0; i < response.length; i++) {
            var st_id = response[i]['id'];
            var st_name = response[i]['name'];
            var opt = "<option data-id='" + st_id + "' value='" + st_name + "'>" + st_name + "</option>";

            $(".csca_wp_states select").append(opt);
          }
        }
      });
    }
  });

  $(".csca_wp_country_1 select").change(function() {
    if ($(".csca_wp_states_1 select").length > 0) {
      var cnt = $(this).children("option:selected").attr('data-id');
      var sel_state = $(".csca_wp_states_1 select").val();
      var sel_city = '';
      var sel_city = $(".csca_wp_cities_1 select").val();
      $(".csca_wp_states_1 select").html('<option value="' + sel_state + '">' + sel_state + '</option>');
      $(".csca_wp_cities_1 select").html('<option value="' + sel_city + '">' + sel_city + '</option>');
      jQuery.ajax({
        url: tc_csca_wp_auto_ajax.ajax_url,
        type: 'post',
        dataType: "json",
        data: {
          action: "csca_wp_states",
          nonce_ajax: tc_csca_wp_auto_ajax.nonce,
          cnt: cnt
        },
        success: function(response) {
          for (i = 0; i < response.length; i++) {
            var st_id = response[i]['id'];
            var st_name = response[i]['name'];
            var opt = "<option data-id='" + st_id + "' value='" + st_name + "'>" + st_name + "</option>";

            $(".csca_wp_states_1 select").append(opt);
          }
        }
      });
    }
  });

  /* --------------------- GET CITIES ------------------------ */

  $(".csca_wp_states select").change(function() {
    if ($(".csca_wp_cities select").length > 0) {
      var sid = $(this).children("option:selected").attr('data-id');
      var sel_city = $(".csca_wp_cities select").val();
      $(".csca_wp_cities select").html('<option value="' + sel_city + '">' + sel_city + '</option>');
      jQuery.ajax({
        url: tc_csca_wp_auto_ajax.ajax_url,
        type: 'post',
        dataType: "json",
        data: {
          action: "csca_wp_cities",
          nonce_ajax: tc_csca_wp_auto_ajax.nonce,
          sid: sid
        },
        success: function(response) {
          for (i = 0; i < response.length; i++) {
            var ct_id = response[i]['id'];
            var ct_name = response[i]['name'];
            var opt = "<option value='" + ct_name + "' data-id='" + ct_id + "'>" + ct_name + "</option>";

            $(".csca_wp_cities select").append(opt);
          }
        }
      });
    }
  });

  $(".csca_wp_states_1 select").change(function() {
    if ($(".csca_wp_cities_1 select").length > 0) {
      var sid = $(this).children("option:selected").attr('data-id');
      var sel_city = $(".csca_wp_cities_1 select").val();
      $(".csca_wp_cities_1 select").html('<option value="' + sel_city + '">' + sel_city + '</option>');
      jQuery.ajax({
        url: tc_csca_wp_auto_ajax.ajax_url,
        type: 'post',
        dataType: "json",
        data: {
          action: "csca_wp_cities",
          nonce_ajax: tc_csca_wp_auto_ajax.nonce,
          sid: sid
        },
        success: function(response) {
          for (i = 0; i < response.length; i++) {
            var ct_id = response[i]['id'];
            var ct_name = response[i]['name'];
            var opt = "<option value='" + ct_name + "' data-id='" + ct_id + "'>" + ct_name + "</option>";

            $(".csca_wp_cities_1 select").append(opt);
          }
        }
      });
    }
  });
});