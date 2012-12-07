$(function() {
    var listOptElem = $("#list-option-wrapper");
    var cValueElem  = '#cvalue';

    toggleListOptionWrapper($(cValueElem));

    function getChunkLengthValue() {
        return $.trim($(cValueElem).val());
    }

    function isNumeric(val) {
        return val !== null && val != '' && !isNaN(val);
    }

    function toggleListOptionWrapper(hardTrans) {
        var cVal = getChunkLengthValue();
        if (isNumeric(cVal)) {
            if (hardTrans === false) {
                listOptElem.fadeIn();
            } else {
                listOptElem.show();
            }
        } else {
            if (hardTrans === false) {
                listOptElem.fadeOut();
            } else {
                listOptElem.hide();
            }
        }
    }

    $(cValueElem).keyup(function() {
        toggleListOptionWrapper(false);
    });

    $('#string-maker').submit(function() {
        // String lenght validation
        var uccount = 0;
        var length = $.trim($('#length').val());
        if (length.length == 0) {
            alert('Please enter a length.');
            return false;
        }

        // String contents validation
        $('#checkboxes input').each(function() {
            if ($(this).attr('checked') != 'checked') {
                uccount++;
            }
        });
        
        if (uccount == 4) {
            alert('You must select at least one type of include for the string.');
            return false;
        }

        // Chunk size validation
        var cSize = getChunkLengthValue();
        if (isNumeric(cSize)) {
            if (parseInt(cSize) >= parseInt(length)) {
                alert('Chunk size must be smaller than the string size.');
                return false;
            }
        }
    });
});