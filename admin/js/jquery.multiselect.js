/*
 * jquery.multiselect.js
 *
 * Author: Adam Bard (adam@adambard.com)
 * Website: https://github.com/adambard/jquery.multiselect.js
 *
 * Copyright (c) 2011 Adam Bard
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

(function($){
    $.fn.multiselect = function(){
        var init_multiselect = function(){
            var source_select = $(this);

            selected_vals = source_select.val() || [];

            var not_selected = $('"<select multiple="multiple" class="options-not-selected"></select>');
            var selected = $('"<select multiple="multiple" class="options-selected"></select>');

            // Copy the name so that the selected bit substitutes for our source.
            selected.attr('name', source_select.attr('name'));

            // Create functions to fire on select and deselect
            // These functions clone the option, rebind click,
            // and append the clone to the opposite list. Then, they
            // destroy their caller.
            var deselect_el = function(){
                var copy = $(this).clone();
                copy.removeAttr('selected');
                copy.unbind('click').bind('click', select_el);
                $(this).closest(".jquery-multiselect").find(".options-not-selected").append(copy);
                $(this).remove()
            };

            var select_el = function(){
                var copy = $(this).clone();
                copy.attr('selected','selected');
                copy.unbind('click').bind('click', deselect_el);
                $(this).closest(".jquery-multiselect").find(".options-selected").append(copy);
                $(this).remove()
            };

            // For IE's benefit, since it doesn't recognize click on <option>s
            var select_click = function(){
                var i = $(this).prop('selectedIndex');
                var opt = $($(this).find('option')[i])

                opt.click()
            }

            // Initialize each option's position, and distribute click callbacks.
            $("option", source_select).each(function(){
                var el = $(this)


                if( $.inArray(el.val(), selected_vals) > -1 ){
                    el.bind('click', deselect_el);
                    selected.append(el);
                }else{
                    el.bind('click', select_el);
                    not_selected.append(el);
                }
            });

            selected.bind('click', select_click);
            not_selected.bind('click', select_click);

            // Create the element that will replace the multiselect
            var el = $('<div class="jquery-multiselect"></div>');

            el.append(not_selected);
            el.append(selected);
            source_select.after(el)
            source_select.remove()


            // Always keep elements in the selected area selected
            el.closest('form').submit(function(){
                $("option", selected).attr('selected','selected');
            })
        }

        this.each(init_multiselect);
    };

    $(document).ready(function(){
        $(function () {
            $("select").css("height", parseInt($("select option").length) * 25);
        });

        $("input.formsend").click(function(){
            var identis = [];
            $.each($("select.options-selected option"), function(){            
                identis.push($(this).val());
            });
            var combi = identis.join(",");
            $("#id_list_field").val(combi.trim());
        });

        /**$('#form1').on('submit', function(e) {
            e.preventDefault()
            var page = $("select").val().join(',');
            var post = $("select").val().join(',');
            var combo = page + post;
            $("#id_list_field").val(combo.trim());
        });**/
    });
})(jQuery);

