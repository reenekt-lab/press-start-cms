$(document).ready(function () {

    // region стрелка в подменю, после загрузки dom дерева в админке
    window.onload=function () {
        //После отображения страницы идет проверка
        //Если Выбран подпунк в пункте "Контент", то стрелка смотит вверх
        if($('.spisok_admin_content').hasClass('display_submenu_admin_content'))
        {
            $('.link_admin_page_content').addClass('admin_content_click');
        }
    };
    //endregion

    //После отображения страницы идет проверка
    //Если Выбран подпунк в пункте "Политика безопасности", то стрелка смотит вверх
    if($('.list_user').hasClass('font_color') || $('.list_roles').hasClass('font_color'))
    {
        $('.link_admin_page_security').addClass('js_arrow_up');
    }

    if($('.link_admin_page_content').hasClass('admin_content_click'))
    {
        $('.link_admin_page_content').removeClass('admin_content_click');
    }

    //region Стрелка в пункте Контент
    $('.admin_content').click(function () {
        if(!$(this).hasClass('admin_content_click'))
        {
            $(this).addClass('admin_content_click');
            $('.spisok_admin_content').addClass('display_submenu_admin_content');
        }
        else
        {
            $(this).removeClass('admin_content_click');
            $('.spisok_admin_content').removeClass('display_submenu_admin_content');
        }
    });
    // endregion

    // region Security
    $('.link_admin_page_security').click(function () {
        if($(this).hasClass('js_arrow_up'))
        {
            $(this).removeClass('js_arrow_up');
            $('.submenu_security_ul').removeClass('display_submenu_security_ul')
        }
        else
        {
            $(this).addClass('js_arrow_up');
            $('.submenu_security_ul').addClass('display_submenu_security_ul')
        }
    });
    //endregion

    //region При нажатии на кнопку "Добавить категорию, она становится неактивной"
    $('.btn_category').click(function () {
        $('.wrap_ajax_form').addClass('display_form');
        $(this).addClass('btn_disapled');
    });
    //endregion

    // region редактор записей
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
        console.error( error );
    } );
    // endregion

    //region При нажатии на главную checkbox, отсальные checkbox тоже отмечаются
    $('.main_checkbox_admin_page').click(function () {
        if($(this).prop('checked'))
        {
            $('.row_checkbox').prop('checked',true);
            $('.disapled_two_tags').css('display','none');
        }else {
            $('.row_checkbox').prop('checked',false);
            $('.disapled_two_tags').css('display','block');
        }
    });
    // endregion

    //region Если нажат хотя бы один checkbox, то можно выбирать действия
    $('.row_checkbox').click(function () {
        var variable=each_check();
        if(variable)
            $('.disapled_two_tags').css('display','none');
        else
            $('.disapled_two_tags').css('display','block');
    });

    function each_check()
    {
        var i=0;
        $('.row_checkbox').each(function () {
            if($(this).prop('checked'))
                 i=1;
        });

        return i;
    }
    //endregion

    //region Если chebox нажат и действие выбрано, то появляется кнопка "Применить"
    $('.select').change(function () {
        $('.input_tag').css('display','block');
    });
    //endregion

    // region preloader
    $('.btn_preloader').click(function () {
        $('body').css('overflow','hidden');
        $('.bg_fix_preloader').css('display','flex');
    });
    // endregion
});

//Список дополнительных категорий
new Vue({
    el:'.rowListAdditionalProperty',
    data:{
        listPropertiesName:[],
        listPropertiesId:[],
        htmlNewRow:'',
        id:1
    },
    mounted:function()
    {
        if(this.$refs.hiddenListPropertyName)
        {
            this.getListPropertyName();
            this.getListPropertyId();

            this.$refs.maxIdJsProperty?this.id=this.$refs.maxIdJsProperty.value:'';
        }
    },
    methods:{
        addRow:function ()
        {
            var newDiv=document.createElement('div');

            newDiv.className='row rowListProperty';
            newDiv.innerHTML='' +
                '<div class="col-md-3 colListProperty">' +
                    '<input type="text" name="JSpropertyName_'+this.id+'">' +
                '</div>'+
                '<div class="col-md-3 colListProperty">'+
                    this.htmlSelect()+
                '</div>'+
                '<div class="col-md-1 d-flex align-items-center colListProperty">' +
                    '<input type="checkbox" name="JSactive_'+this.id+'" checked>'+
                '</div>'+
                '<div class="col-md-3 colListProperty">' +
                    '<input type="text" name="JSsymbolCode_'+this.id+'">'+
                '</div>'+
                '<div class="col-md-1 colListProperty"></div>'+
                '<div class="col-md-1"></div>';

            document.querySelector('.wrapAdditionalPropertyJs').appendChild(newDiv);

            this.htmlNewRow=document.querySelector('.wrapAdditionalPropertyJs').innerHTML;

            this.id++;
        },

        htmlSelect:function (listProperties)
        {
            var htmlSelect='<select name="JSlistProperties_'+this.id+'">';
            var i=0;

            this.listPropertiesName.forEach(element=>{
                htmlSelect+='<option value="'+this.listPropertiesId[i]+'">'+element+'</option>';
                i++;
            });

            htmlSelect+='</select>';

            return htmlSelect;
        },

        getListPropertyName:function ()
        {
            var A=this.$refs.hiddenListPropertyName.innerText.split(/\s/).join('');
            var B=A.split('|');

            B.pop();

            B.forEach(element=>{
                this.listPropertiesName.push(element);
            });
        },

        getListPropertyId:function ()
        {
            var A=this.$refs.hiddenListPropertyId.innerText.split(/\s/).join('');
            var B=A.split('|');

            B.pop();

            B.forEach(element=>{
                this.listPropertiesId.push(element);
            });
        },

        displayPreloader:function ()
        {
            document.querySelector('.bg_fix_preloader').style.display='flex';
            document.querySelector('body').style.overflow='hidden';
        }
    }
});
