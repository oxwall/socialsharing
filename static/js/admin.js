var socialSharingAdmin = function( $params )
{
    var self = this;

    this.responderUrl = $params.ajaxResponderUrl;
    var $questionTable = $('#socialsharing_settings');
    
    var checkbox = $('.sharing_item input[type="checkbox"]');
    
    checkbox.click(function(){
        $.ajax( {
            url: self.responderUrl,
            type: 'POST',
            data: {
                command: 'save_settings',
                key: $(this).attr("name"),
                value: $(this).is(':checked') ? 1 : 0
            },
            dataType: 'json'
        } );
    });

    $questionTable.sortable(
    {
        items: '.sharing_item',
        cursor: 'move',
        placeholder: 'forum_placeholder',
        snap: true,
        snapToleranse: 50,
        forcePlaceholderSize: true,
        connectWith: '#socialsharing_settings',

        update: function(event, ui)
        {
            var table = ui.item.parents("#socialsharing_settings");
            
            var orderNew = {};

            table.find('.sharing_item').each(function(order, o){
                orderNew[$(o).attr('item')] = order;
            });

            var $items = $questionTable.find(".sharing_item");
            $items.removeClass('ow_alt1');
            $items.removeClass('ow_alt2');

            $questionTable.find('.sharing_item:odd').addClass('ow_alt2');
            $questionTable.find('.sharing_item:even').addClass('ow_alt1');

            $.ajax( {
                url: self.responderUrl,
                type: 'POST',
                data: {
                    command: 'sort_sharing_item',
                    order:JSON.stringify(orderNew)
                },
                dataType: 'json'
            } );

        },

        start: function(event, ui)
        {
            $(ui.placeholder).append('<td colspan="2"></td>');
        }
    });
}