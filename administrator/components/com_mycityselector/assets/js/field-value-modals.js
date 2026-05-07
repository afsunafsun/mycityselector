/**
 * MyCitySelector — field value modals on field edit (Joomla 6 / Bootstrap 5).
 *
 * Core system/modal-fields-uncompressed.js expects modal id on element.parentNode.parentNode,
 * but Joomla modal markup places the id on .joomla-modal (ancestor of .modal-footer).
 * Also replaces jQuery.fn.modal('hide') with bootstrap.Modal when needed.
 *
 * Logic mirrors media/system/js/modal-fields-uncompressed.js (processModalEdit).
 */
(function () {
  'use strict';

  function resolveModalId(element) {
    if (!element) {
      return '';
    }
    if (element.closest) {
      var host = element.closest('.joomla-modal');
      if (host && host.id) {
        return host.id;
      }
    }
    var p = element.parentNode && element.parentNode.parentNode;
    return p && p.id ? p.id : '';
  }

  function hideModal(modalId) {
    if (!modalId) {
      return;
    }
    var node = document.getElementById(modalId);
    if (!node) {
      return;
    }
    if (window.bootstrap && window.bootstrap.Modal) {
      window.bootstrap.Modal.getOrCreateInstance(node).hide();
      return;
    }
    if (typeof window.jQuery !== 'undefined' && typeof window.jQuery.fn.modal === 'function') {
      window.jQuery('#' + modalId).modal('hide');
    }
  }

  var orig = window.processModalEdit;
  if (typeof orig !== 'function') {
    return;
  }

  window.processModalEdit = function (element, fieldPrefix, action, itemType, task, formId, idFieldId, titleFieldId) {
    formId = formId || itemType.toLowerCase() + '-form';
    idFieldId = idFieldId || 'jform_id';
    titleFieldId = titleFieldId || 'jform_title';

    var modalId = resolveModalId(element);
    var submittedTask = task;

    if (!modalId) {
      return orig.apply(window, arguments);
    }

    var jq = window.jQuery('#' + modalId + ' iframe');
    if (!jq.length || !jq.get(0)) {
      return false;
    }
    jq.get(0).id = 'Frame_' + modalId;

    var iframeDocument = window.jQuery('#Frame_' + modalId).contents().get(0);

    if (task === 'cancel') {
      document.getElementById('Frame_' + modalId).contentWindow.Joomla.submitbutton(itemType.toLowerCase() + '.' + task);
      hideModal(modalId);
    } else {
      window.jQuery('#Frame_' + modalId).on('load', function () {
        iframeDocument = window.jQuery(this).contents().get(0);

        if (iframeDocument.getElementById(idFieldId) && iframeDocument.getElementById(idFieldId).value !== '0') {
          window.processModalParent(
            fieldPrefix,
            iframeDocument.getElementById(idFieldId).value,
            iframeDocument.getElementById(titleFieldId).value
          );

          if (task === 'save') {
            window.processModalEdit(element, fieldPrefix, 'edit', itemType, 'cancel', formId, idFieldId, titleFieldId);
          }
        }

        window.jQuery('#' + modalId + ' iframe').removeClass('hidden');
      });

      if (iframeDocument.formvalidator.isValid(iframeDocument.getElementById(formId))) {
        if (task === 'save') {
          submittedTask = 'apply';
        }

        document.getElementById('Frame_' + modalId).contentWindow.Joomla.submitbutton(itemType.toLowerCase() + '.' + submittedTask);
      }
    }

    return false;
  };

  document.addEventListener('DOMContentLoaded', function () {
    var hash = window.location.hash || '';
    if (hash.indexOf('fieldValueModal') !== 1) {
      return;
    }
    var modalEl = document.querySelector(hash);
    if (!modalEl || !window.bootstrap || !window.bootstrap.Modal) {
      return;
    }
    window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
  });
})();
