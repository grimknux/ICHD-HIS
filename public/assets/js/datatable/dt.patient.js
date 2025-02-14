/*
 *  Document   : uiTables.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Tables page
 */

var dtPatient = function() {

    return {
        init: function() {
            /* Initialize Bootstrap Datatables Integration */
            App.datatables();

            /* Initialize Datatables */
           	

            var pat_tbl = $("#pat_Datatable").dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: base_url + '/get/table/patient',
                    data: function(d) {
                        d.pat_idFilter = $('#patient_id_filter').val() || '';  // Default to empty string if no value
                        d.pat_lnameFilter = $('#patient_lname_filter').val() || '';
                        d.pat_fnameFilter = $('#patient_fname_filter').val() || '';
                        d.pat_mnameFilter = $('#patient_mname_filter').val() || '';
                        d.pat_bdateFilter = $('#patient_bdate_filter').val() || '';
                    },
                    dataSrc: function (json) {
                        if (json.hasOwnProperty('error')) {
                            console.log("Ajax error occurred: " + json.error);
                            return [];
                        } else {
                            console.log("Success");
                            return json.data;
                        }
                    },
                    type: "post",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                    },
                    error: function (xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert("Error Code " + xhr.status + ": " + error + "\n" +
                                "Message: " + xhr.responseJSON.error);
                        } else {
                            alert('An unknown error occurred.');
                        }
                    }
                },
                className: "tbody-sm",
                columns: [
                    { data: "pat_id" },
                    { data: "pat_name" },
                    { data: "pat_sex" },
                    { data: "pat_bdate" },
                    { data: "pat_address" },
                    { data: "action" },
                ],
                columnDefs: [
                    { 
                        "targets": [0,2,3,5],
                        "className": "text-center",
                        "orderable": false
                    }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                drawCallback: function(settings) {
                    // Get total filtered records and pages
                    var totalRecords = settings.json.recordsFiltered;
                    var pageLength = settings._iDisplayLength;
                    
                    // Calculate the number of pages
                    var pageCount = Math.ceil(totalRecords / pageLength);
            
                    // Get current page
                    var currentPage = Math.ceil(settings._iDisplayStart / pageLength);
            
                    // Show/hide pagination based on the number of pages
                    if (pageCount <= 1) {
                        $('.dataTables_paginate').hide();  // Hide pagination if there's only one page
                    } else {
                        $('.dataTables_paginate').show();  // Show pagination if more than one page
                    }
            
                    // Optional: You can add any custom logic or actions after each redraw
                    console.log("Current Page: " + currentPage + ", Total Pages: " + pageCount);
                }
            });


            var pat_tbl_2 = $("#pat_Datatable_2").dataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: base_url + '/get/table/patient2',
                    dataSrc: function (json) {
                        if (json.hasOwnProperty('error')) {
                            console.log("Ajax error occurred: " + json.error);
                            return [];
                        } else {
                            console.log("Success");
                            return json;
                        }
                    },
                    type: "post",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                    },
                    error: function (xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert("Error Code " + xhr.status + ": " + error + "\n" +
                                "Message: " + xhr.responseJSON.error);
                        } else {
                            alert('An unknown error occurred.');
                        }
                    }
                },
                className: "tbody-sm",
                
                "order": [[1, "asc"]],
                columns: [
                    { data: "pat_id" },
                    { data: "pat_name" },
                    { data: "pat_sex" },
                    { data: "pat_bdate" },
                    { data: "pat_address" },
                    { data: "action" },
                ],
                columnDefs: [
                    { 
                        "targets": [0,2,3,5],
                        "className": "text-center",
                        "orderable": false
                    }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
            });
            

			
            /* Add placeholder attribute to the search input */
            $('.dataTables_filter input').attr('placeholder', 'Search');

            /* Select/Deselect all checkboxes in tables */
            $('thead input:checkbox').click(function() {
                var checkedStatus   = $(this).prop('checked');
                var table           = $(this).closest('table');

                $('tbody input:checkbox', table).each(function() {
                    $(this).prop('checked', checkedStatus);
                });
            });

            /* Table Styles Switcher */
            var genTable        = $('#general-table');
            var styleBorders    = $('#style-borders');

            $('#style-default').on('click', function(){
                styleBorders.find('.btn').removeClass('active');
                $(this).addClass('active');

                genTable.removeClass('table-bordered').removeClass('table-borderless');
            });

            $('#style-bordered').on('click', function(){
                styleBorders.find('.btn').removeClass('active');
                $(this).addClass('active');

                genTable.removeClass('table-borderless').addClass('table-bordered');
            });

            $('#style-borderless').on('click', function(){
                styleBorders.find('.btn').removeClass('active');
                $(this).addClass('active');

                genTable.removeClass('table-bordered').addClass('table-borderless');
            });

            $('#style-striped').on('click', function() {
                $(this).toggleClass('active');

                if ($(this).hasClass('active')) {
                    genTable.addClass('table-striped');
                } else {
                    genTable.removeClass('table-striped');
                }
            });

            $('#style-condensed').on('click', function() {
                $(this).toggleClass('active');

                if ($(this).hasClass('active')) {
                    genTable.addClass('table-condensed');
                } else {
                    genTable.removeClass('table-condensed');
                }
            });

            $('#style-hover').on('click', function() {
                $(this).toggleClass('active');

                if ($(this).hasClass('active')) {
                    genTable.addClass('table-hover');
                } else {
                    genTable.removeClass('table-hover');
                }
            });

            this.bindEvents(pat_tbl);
        },

        bindEvents: function(pat_tbl) {
            $(document)
                .on('click', '#filterBtn', this.filterPatientTable.bind(this,pat_tbl))
                .on('click', '#cancelSearch', this.cancelSearchBtn.bind(this,pat_tbl))
        },

        filterPatientTable: function(tbl,event) {
            event.preventDefault();
            tbl.api().ajax.reload();
            $('#searchModal').modal('hide');
            $('#patient_id_filter').val("");
            $('#patient_lname_filter').val("");
            $('#patient_fname_filter').val("");
            $('#patient_mname_filter').val("");
            $('#patient_bdate_filter').val("");

            $('#cancelSearch').show();
        },

        cancelSearchBtn: function(tbl,event) {
            event.preventDefault();
            tbl.api().ajax.reload();
            $('#cancelSearch').hide();
            
        },
    
    };
}();