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

//SideBarAdminPage
new Vue({
    el:'.sidebarMenu',
    methods:{
        displaySubMenuSetting:function ()
        {
            var classObject=document.querySelector('.js_setting');

            if (classObject.classList.contains('js_display_sub_menu')) {
                classObject.classList.remove('js_display_sub_menu');
                document.querySelector('.setting').classList.remove('rollArrow');
            } else {
                classObject.classList.add('js_display_sub_menu');
                document.querySelector('.setting').classList.add('rollArrow');
            }
        }
    }
});

//Список дополнительных категорий
new Vue({
    el:'.rowListAdditionalProperty',
    data:{
        listPropertiesName:[],
        listPropertiesId:[],

        // Количесво строк отображаемых в цикле
        countNewRow:[],
        id:1,

        // ID для элементов, чтобы можно было бы работать
        idSelectedProp:0,
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
            this.countNewRow.push(this.id++);
        },

        htmlSelect:function (itemID)
        {
            var htmlSelect='<select class="JSlistProperties_'+itemID+'" name="JSlistProperties_'+itemID+'">';
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

        addModalWindowInput:function()
        {
            var newDiv=document.createElement('div');
            newDiv.classList='bgFormSettingAddProp JSmodalWindowInput_'+this.id;
            newDiv.style='display:none';

            newDiv.innerHTML='' +
                '<div class="justWrap">' +
                    '<div class="wrapFormSettingAddProp">' +
                        '<div class="wrapAdminPageAddPropSettingLeft">' +
                            '<p>' +
                                'Значение по умолчанию'+
                            '</p>'+
                        '</div>'+
                        '<div class="wrapAdminPageAddPropSettingRight">' +
                            '<input type="text" name="JSsettingAdditionalPropDefaultValInput_'+this.id+'">'+
                        '</div>'+
                    '</div>'+
                    '<div class="wrapBlockBtnSaveSetting">' +
                        '<div class="wrapLeftBlockBtnSettingAddProp">' +
                            '<div class="btnSaveSetting">Закрыть</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

            document.querySelector('.tableAdditionalProp').appendChild(newDiv);
        },

        displayPreloader:function ()
        {
            document.querySelector('.bg_fix_preloader').style.display='flex';
            document.querySelector('body').style.overflow='hidden';
        },

        displayModalWindow:function(id)
        {
            this.idSelectedProp=document.querySelector(".listProperties_"+id).value;

            if(this.idSelectedProp==1)
            {
                this.$refs['modalWindowInput_'+id].style.display='flex';
            }
            else if(this.idSelectedProp==2)
            {
                this.$refs['modalWindowTextArea'+id].style.display='flex';
            }
        },

        closeModalWindowProp:function (id)
        {
            if(this.idSelectedProp==1)
            {
                document.querySelector('.modalWindowInput_'+id).style.display='none';
            }
            else if (this.idSelectedProp==2)
            {
                document.querySelector('.modalWindowTextArea_'+id).style.display='none';
            }
        },

        JSopenModalWindow:function (id)
        {
            console.clear();
            console.log('ID: '+id);
            this.idSelectedProp=document.querySelector(".JSlistProperties_"+id).value;

            if(this.idSelectedProp==1)
            {
                document.querySelector('.JSbgFormSettingInputAddProp_'+id).style.display='flex';
            }
            else if(this.idSelectedProp==2)
            {
                document.querySelector('.JSbgFormSettingTextAreaAddProp_'+id).style.display='flex';
            }
        },

        JScloseModalWindowProp:function (id)
        {
            if(this.idSelectedProp==1)
            {
                // Закрывает те модальные окна, где есть выбранный ID
                // Но т.к. мне лень создавать ещё функцию закрытия модального окна для каждого свойства
                // Я закрываю все модальные окна, где есть определенный ID

                document.querySelector('.JSbgFormSettingInputAddProp_'+id).style.display='none'
            }
            else if(this.idSelectedProp==2)
            {
                document.querySelector('.JSbgFormSettingTextAreaAddProp_'+id).style.display='none'
            }
        }
    }
});
