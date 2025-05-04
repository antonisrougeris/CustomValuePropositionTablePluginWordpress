jQuery(document).ready(function ($) {
    let counter = $('#bct-table-items-container .bct-table-item').length;

    $('#add-bct-item').on('click', function () {
        const html = `
            <div class="bct-table-item">
                <input type="text" name="bct-table-items[${counter}][feature]" placeholder="Feature" />
                <input type="text" name="bct-table-items[${counter}][us]" placeholder="Us" />
                <input type="text" name="bct-table-items[${counter}][competitor]" placeholder="Competitor" />
            </div>
        `;
        $('#bct-table-items-container').append(html);
        counter++;
    });

    
});


jQuery(document).ready(function($) {
    const preview = $('#bct-live-preview');
  
    function updatePreview() {
      preview.css({
        '--bct-color': $('[name="bct-accent-color"]').val(),
        '--bct-bg-color': $('[name="bct-bg-color"]').val(),
        '--bct-header-bg': $('[name="bct-header-bg-color"]').val(),
        '--bct-text-color': $('[name="bct-text-color"]').val(),
        '--bct-border-color': $('[name="bct-border-color"]').val(),
        '--bct-hover-bg': $('[name="bct-hover-bg-color"]').val(),
        '--bct-hover-text': $('[name="bct-hover-text-color"]').val(),
        '--bct-radius': $('[name="bct-radius"]').val() + 'px',
        '--bct-font-size': $('[name="bct-font-size"]').val() + 'px',
        '--bct-header-font-size': $('[name="bct-header-font-size"]').val() + 'px',
        '--bct-cell-padding': $('[name="bct-cell-padding"]').val() + 'px',
      });
  
      const rowStyle = $('[name="bct-row-separator-style"]').val();
      preview.css('--bct-row-separator', rowStyle);
    }
  
    $('input[type="color"], input[type="number"], select').on('input change', updatePreview);
  });
  