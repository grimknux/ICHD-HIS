const patientApp = {

    init: function() {
        this.bindEvents();
    },

    bindEvents: function() {
        $(document)
            .on('change', '#pat_current_city', this.populateMunicipality.bind(this, '#pat_current_brgy', '#pat_current_district'))
            .on('change', '#pat_current_district', this.populateZipByDistrict.bind(this, '#pat_current_zip'))
            .on('change', '#pat_permanent_city', this.populateMunicipalityPerm.bind(this, '#pat_permanent_brgy', '#pat_permanent_district'))
            .on('change', '#pat_permanent_district', this.populateZipByDistrictPerm.bind(this, '#pat_permanent_zip'))
            .on('change', '#same_address', this.sameAddress.bind(this))
            .on('input', '#pat_lname, #pat_fname, #pat_mname', this.updateFullName)
            .on('change', '#pat_suffix', this.updateFullName)
            .on('click', '.registerBtn', this.submitRegisterPatient.bind(this))
            .on('click', '.updateBtn', this.updatePatient.bind(this))
            .on('click', '#pat_Datatable tbody .view-detail', this.viewPatientDetail)
            .on('click', '#pat_Datatable tbody .delete-patient-btn', this.deletePatient)
            .on('click', '#pat_Datatable_2 tbody .view-detail', this.viewPatientDetail)
            .on('click', '#pat_Datatable_2 tbody .delete-patient-btn', this.deletePatient)
    },


    ajaxRequest: function(options) {
        var defaultOptions = {
            url: '',
            type: 'POST',
            data: {},
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                $("#overlay").show();
            },
            success: function(response) {},
            error: function(xhr, errorType, thrownError) {
                if (xhr.status === 403 || xhr.status === 405) {
                    alert(xhr.responseText);    
                    console.log("Server error: " + xhr.responseText);
                } else {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : xhr.statusText;
                    console.log("Server error: " + xhr.responseText);
                }
            },
            complete: function() {
                $("#overlay").hide();
            }
        };

        // Extend default options with custom options
        $.extend(defaultOptions, options);

        // Perform the AJAX request
        $.ajax(defaultOptions);
    },

    submitRegisterPatient : function(event) {
        event.preventDefault();

        var form = $('#registerPatientForm')[0];
        var formData = new FormData(form);

        patientApp.ajaxRequest({
            url: base_url + '/form/patient/register',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#pat_current_brgy').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_current_province').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_permanent_brgy').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_permanent_province').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_current_district').prop('disabled', true).trigger("change");
                    $('#pat_permanent_district').prop('disabled', true).trigger("change");
                    patientApp.clearFormValidation(form);
                    setTimeout(function() {
                        window.location.href = base_url + "patient/view";
                    }, 1000); // Redirects after 3 seconds
                    



                } else {

                    if(response.formnotvalid){

                        handleValidationErrors(response.data);
                        $('.select-select2').select2();

                    }else{

                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: response.message,
                        });
                        patientApp.clearFormValidation();

                    }
                }
            }
        });
    },

    updatePatient : function(event) {
        event.preventDefault();

        var form = $('#updatePatientForm')[0];
        var formData = new FormData(form);

        patientApp.ajaxRequest({
            url: base_url + '/form/patient/update',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#pat_current_brgy').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_current_province').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_permanent_brgy').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_permanent_province').empty().append('<option value="">Select option</option>').trigger('change');
                    $('#pat_current_district').prop('disabled', true).trigger("change");
                    $('#pat_permanent_district').prop('disabled', true).trigger("change");
                    patientApp.clearFormValidation(form);
                    setTimeout(function() {
                        window.location.href = base_url + "patient/view";
                    }, 1000); // Redirects after 3 seconds
                    



                } else {

                    if(response.formnotvalid){

                        handleValidationErrors(response.data);
                        $('.select-select2').select2();

                    }else{

                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: response.message,
                        });
                        patientApp.clearFormValidation();

                    }
                }
            }
        });
    },

    viewPatientDetail: function() {
        var id = $(this).data('id'); 
        var modal = $("#viewPatientModal");

        patientApp.ajaxRequest({
            url: base_url + '/get/view/data/patient',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {

                    modal.find('#pat_code').html(response.pat_code);
                    modal.find('#pat_name').html(response.pat_name);
                    modal.find('#pat_sex').html(response.pat_sex);
                    modal.find('#pat_bdate').html(response.pat_bdate);
                    modal.find('#pat_age').html(response.pat_age);
                    modal.find('#pat_cs').html(response.pat_cs);
                    modal.find('#pat_blood').html(response.pat_blood);
                    modal.find('#pat_nationality').html(response.pat_nationality);
                    modal.find('#pat_religion').html(response.pat_religion);
                    modal.find('#pat_mobile').html(response.pat_mobile);
                    modal.find('#pat_tel').html(response.pat_tel);
                    modal.find('#pat_email').html(response.pat_email);
                    modal.find('#pat_ref_name').html(response.pat_ref_name);
                    modal.find('#pat_ref_address').html(response.pat_ref_address);
                    modal.find('#pat_ref_number').html(response.pat_ref_number);
                    modal.find('#pat_cur_street').html(response.pat_cur_street);
                    modal.find('#pat_cur_city').html(response.pat_cur_city);
                    modal.find('#pat_cur_brgy').html(response.pat_cur_brgy);
                    modal.find('#pat_cur_district').html(response.pat_cur_district);
                    modal.find('#pat_cur_zip').html(response.pat_cur_zip);
                    modal.find('#pat_cur_province').html(response.pat_cur_province);
                    modal.find('#pat_per_street').html(response.pat_per_street);
                    modal.find('#pat_per_city').html(response.pat_per_city);
                    modal.find('#pat_per_brgy').html(response.pat_per_brgy);
                    modal.find('#pat_per_district').html(response.pat_per_district);
                    modal.find('#pat_per_zip').html(response.pat_per_zip);
                    modal.find('#pat_per_province').html(response.pat_per_province);
                    
                    modal.modal('show');
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message,
                    });
                }
            }
        });
    },

    deletePatient: function() {
        var id = $(this).data('id'); 

        Swal.fire({
            title: "Are you sure you want to delete this Patient?",
            text: "This can't be reversed. Continue?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete!"
        }).then((result) => {
            if (result.isConfirmed) {

                patientApp.ajaxRequest({
                    url: base_url + '/form/patient/delete',
                    data: { id: id },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#pat_Datatable').DataTable().ajax.reload(null, false);
                            $('#pat_Datatable_2').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: response.message,
                            });
                        }
                    }
                });

            }
        });
        
    },
        

    sameAddress: function(event) {
        let isChecked = $("#same_address").prop("checked");

        if (isChecked) {
            $("#div_permanent_address").hide();
        } else {
            $("#div_permanent_address").show();
            $('.select-select2').trigger("change.select2");
        }
    },


    populateMunicipality: function(brgySelector, districtSelector, event) {
        const selectMunCity = $(event.target);
        var munCity = selectMunCity.val();
        var brgyElement = $(brgySelector);
        var districtElement = $(districtSelector);

        patientApp.ajaxRequest({
            url: base_url + '/get/patient/lib/municipality',
            data: { muncity: munCity },
            success: function(response) {
                if (response.success) {

                        if(response.dist_true){
                            districtElement.removeAttr('disabled').trigger("change");
                            $('.label-current-district').addClass('label-require');
                            patientApp.populateSelect(districtElement, response.district, response.districtKeys.textKey, response.districtKeys.valueKey);
    
                        }else{
                            districtElement.empty();
                            $('.label-current-district').removeClass('label-require');
                            districtElement.prop('disabled', true).trigger("change");
                        }

                        patientApp.populateSelect(brgyElement, response.brgy, response.brgyKeys.textKey, response.brgyKeys.valueKey);
                        $('#pat_current_zip').val(response.zipcode);
                        $('#pat_current_province').val(response.province).trigger("change");
                        $('#pat_current_region').val(response.region).trigger("change");
                    

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message,
                    });
                }
            }
        });
 
    },

    populateZipByDistrict: function(zipSelector, event) {

        const selectDistrict = $(event.target);
        var district = selectDistrict.val();
        var zipElement = $(zipSelector);

        if(district){
            $('#pat_current_zip').val(district);
            //alert(district);
        }else{
            $('#pat_current_zip').val("");
        }
 
    },


    populateMunicipalityPerm: function(brgySelector, districtSelector, event) {
        const selectMunCity = $(event.target);
        var munCity = selectMunCity.val();
        var brgyElement = $(brgySelector);
        var districtElement = $(districtSelector);

        patientApp.ajaxRequest({
            url: base_url + '/get/patient/lib/municipality',
            data: { muncity: munCity },
            success: function(response) {
                if (response.success) {

                        if(response.dist_true){
                            districtElement.removeAttr('disabled').trigger("change");
                            $('.label-permanent-district').addClass('label-require');
                            patientApp.populateSelect(districtElement, response.district, response.districtKeys.textKey, response.districtKeys.valueKey);
    
                        }else{
                            districtElement.empty();
                            $('.label-permanent-district').removeClass('label-require');
                            districtElement.prop('disabled', true).trigger("change");
                        }

                        patientApp.populateSelect(brgyElement, response.brgy, response.brgyKeys.textKey, response.brgyKeys.valueKey);
                        $('#pat_permanent_zip').val(response.zipcode);
                        $('#pat_permanent_province').val(response.province).trigger("change");
                        $('#pat_permanent_region').val(response.region).trigger("change");
                    

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message,
                    });
                }
            }
        });
 
    },

    populateZipByDistrictPerm: function(zipSelector, event) {

        const selectDistrict = $(event.target);
        var district = selectDistrict.val();
        var zipElement = $(zipSelector);

        if(district){
            $('#pat_permanent_zip').val(district);
            //alert(district);
        }else{
            $('#pat_permanent_zip').val("");
        }
 
    },


    updateFullName: function(){
        
        let lastName = $.trim($("#pat_lname").val());
        let firstName = $.trim($("#pat_fname").val());
        let middleName = $.trim($("#pat_mname").val());
        let suffix = $("#pat_suffix").val();

        let fullName = lastName + 
            (lastName && firstName ? ", " : "") + 
            firstName + 
            (middleName ? " " + middleName : "") + 
            (suffix ? " " + suffix : "");

        $("#pat_fullname").val(fullName);
    },



    
    populateSelect: function(selectElement, options, textKey, valueKey, selected = "") {
        selectElement.empty();
        selectElement.append('<option value="">Select option</option>');
        const selectedArray = (selected !== null && selected !== "") ? selected.split(',').map(ap => ap.trim()) : [];

        options.forEach(function(optionData) {
            const option = new Option(optionData[textKey], optionData[valueKey]);
            if (selectedArray.includes(optionData[valueKey])) {
                option.selected = true;
            }
            selectElement.append(option);
        });

        selectElement.trigger('change');

    },


    clearFormValidation: function(form = "") {
        if (form && form.length) {
            form.reset();
        }
        $('.has-success').removeClass('has-success');
        $('.has-error').removeClass('has-error');
        $('.help-block').empty();

        $('.select-select2').trigger("change.select2");

    },

}