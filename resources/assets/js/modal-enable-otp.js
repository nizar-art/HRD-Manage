/**
 * Add Category Department
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const categoryDepartmentMask = document.querySelector('#modalAddCategoryDepartment');

    // Category Department Input Mask
    if (categoryDepartmentMask) {
      new Cleave(categoryDepartmentMask, {
        blocks: [50], // Allow up to 50 characters for the input
        delimiter: '',
        uppercase: false // Allow mixed case for the input
      });
    }

    // Add Category Department form validation
    FormValidation.formValidation(document.getElementById('addCategoryDepartmentForm'), {
      fields: {
        modalAddCategoryDepartment: {
          validators: {
            notEmpty: {
              message: 'Please enter a category or department name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          //* Move the error message out of the `input-group` element
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    });
  })();
});
