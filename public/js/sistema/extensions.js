$.fn.extend({
    loadGrid: function (url, args, selector, callback) {
        this.each(function () {
            $(this).html('');
            $(this).html("<div class='text-center'><h3><i class='fa fa-spinner fa-pulse'></i> Carregando...</h3></div>");
        });

        if (selector == '' || selector == null)
            selector = '.table-responsive';
        var aux = 0;
        var acrescentar = false;
        if (!empty(args)) {
            $.each(args, function (key, value) {
                if (key == 'first' && value == 1) {
                    acrescentar = true;
                }
                if (strripos(value, ' ') > 0) {
                    value = replaceAll(value, ' ', '%20');
                }
                if (aux == 0) {
                    url += '/?' + key + '=' + value;
                } else {
                    url += '&' + key + '=' + value;
                }
                aux = 1;
            });
        }
        if (acrescentar) {
            Acrescentar(url)
        }
        url += ' ' + selector;

        if ($.isFunction(callback)) {
            return $(this).load(url, callback);
        } else {
            return $(this).load(url);

        }
    },
})
$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
var auxiliares = {
    click: null,
    filter: null
};

function number_format(number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
    var n = !isFinite(+number) ? 0 : +number
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
    var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
    var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
    var s = ''

    var toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec)
        return '' + (Math.round(n * k) / k)
            .toFixed(prec)
    }

    // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
    }

    return s.join(dec)
}

function empty(mixed_var) {
    var undef, key, i, len;
    var emptyValues = [undef, null, false, 0, '', '0'];
    for (i = 0, len = emptyValues.length; i < len; i++) {
        if (mixed_var === emptyValues[i]) {
            return true;
        }
    }
    if (typeof mixed_var === 'object') {
        for (key in mixed_var) {
            // TODO: should we check for own properties only?
            //if (mixed_var.hasOwnProperty(key)) {
            return false;
            //}
        }
        return true;
    }
    return false;
}

function strripos(haystack, needle, offset) {
    //  discuss at: http://locutus.io/php/strripos/
    // original by: Kevin van Zonneveld (http://kvz.io)
    // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //    input by: saulius
    //   example 1: strripos('Kevin van Zonneveld', 'E')
    //   returns 1: 16

    haystack = (haystack + '')
        .toLowerCase()
    needle = (needle + '')
        .toLowerCase()

    var i = -1
    if (offset) {
        i = (haystack + '')
            .slice(offset)
            .lastIndexOf(needle) // strrpos' offset indicates starting point of range till end,
        // while lastIndexOf's optional 2nd argument indicates ending point of range from the beginning
        if (i !== -1) {
            i += offset
        }
    } else {
        i = (haystack + '')
            .lastIndexOf(needle)
    }
    return i >= 0 ? i : false
}

function replaceAll(string, token, newtoken) {
    while (string.indexOf(token) != -1) {
        string = string.replace(token, newtoken);
    }
    return string;
}

function form_campos(element) {
    $(element).find("[data-gallery='gal']").each(function () {
        $(this).click(function (event) {
            event = event || window.event;
            var target = event.target || event.srcElement,
                link = target.src ? target.parentNode : target,
                options = {index: link, event: event},
                links = $("[data-gallery='gal']")
            blueimp.Gallery(links, options);
            console.log(this)
            return false;
        })
    })

    $(element).find('select').select2({
        allowClear: true,
        width: '100%',
        openOnEnter: false,
        theme: "bootstrap",
        language: "pt-BR",
        placeholder: {
            id: '-1',
            text: 'Selecione'
        },
    });

    $(element).find('[toggle="tooltip"]').tooltip();

    $(element).find('.input-file-xml').each(function () {
        $(this).fileinput({
            showUpload: false,
            maxFileCount: 1,
            layoutTemplates: {
                main1: "{preview}\n" +
                "<div class=\'input-group {class}\'>\n" +
                "   <div class=\'input-group-btn\'>\n" +
                "       {browse}\n" +
                "       {upload}\n" +
                "       {remove}\n" +
                "   </div>\n" +
                "   {caption}\n" +
                "</div>"
            },
            allowedFileExtensions: ["xml"]
        });
    });

    $(element).find('.input-file').each(function () {
        $(this).fileinput({
            showUpload: false,
            maxFileCount: 20,
            layoutTemplates: {
                main1: "{preview}\n" +
                "<div class=\'input-group {class}\'>\n" +
                "   <div class=\'input-group-btn\'>\n" +
                "       {browse}\n" +
                "       {upload}\n" +
                "       {remove}\n" +
                "   </div>\n" +
                "   {caption}\n" +
                "</div>"
            },
            allowedFileExtensions: ["jpg", "gif", "png", "txt", "pdf", "rar"]
        });
    });
    $(element).find('[data="tags"]').each(function () {
        $(this).tagsinput({
            confirmKeys: [13, 188]
        });

        $(this).find('input').on('keypress', function(e){
            console.log(e)
            if (e.keyCode == 13){
                e.keyCode = 188;
                e.preventDefault();
            }
        });

    });

    $(element).find('[data="select"]').each(function () {
        var action = $(this).attr('action')
        var parametro = $(this).attr('data-paran')
        var campo = $(this).attr('data-campo')
        var hasmany = $(this).attr('hasmany')

        $(this).select2({
            language: 'pt-BR',
            theme: 'bootstrap',
            width: '100%',
            placeholder: {
                id: '-1',
                text: 'Selecione'
            },
            minimumInputLength: !empty($(this).attr("sel")) ? 1 : 0,
            ajax: {
                url: action,
                dataType: 'json',
                cache: true,
                type: 'post',
                data: function (params) {
                    return {
                        termo: !empty(params.term) ? params.term : '',
                        size: 10,
                        page: params.page,
                        auxiliar: !empty(parametro) ? $("#" + parametro).val() : '',
                        campo: !empty(campo) ? campo : '',
                        hasmany: !empty(hasmany) ? hasmany : ''
                    };
                },
                processResults: function (data) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: data.dados,
                        pagination: {
                            more: data.more
                        }
                    }
                }
            }
        });
    });
    $(element).find('[sel="update"]').each(function () {
        var action_update = $(this).attr('update')
        var campo = $(this)
        if (!empty(action_update)) {
            $.ajax({
                url: action_update,
                type: 'get',
                beforeSend: function () {
                    campo.html('<option value="">carregando...</option>');
                },
                success: function (data) {
                    if (!empty(data)) {

                        campo.html('<option value="">Selecione</option>');
                        campo.append('<option value="' + data.id + '" selected>' + data.descricao + '</option>').trigger('change')
                    }
                }
            });
        }

    });
    $(element).find('.input-file-edit').each(function () {
        $(this).fileinput({
            maxFileCount: 20,
            overwriteInitial: false,
            initialPreview: "<img src='" + $(this).attr('link-img') + "' class='file-preview-image img-responsive' />",
            initialPreviewConfig: [
                {
                    caption: $(this).attr('descricao-img'),
                    width: "120px",
                    method:"POST",
                    url: SITE_PATH + "/" + $(this).attr('controller-img') + "/delete_img/" + $(this).attr('img-id'),
                    key: $(this).attr('img-id')
                },
            ],
            layoutTemplates: {
                main1: "{preview}\n" +
                "<div class=\'input-group {class}\'>\n" +
                "   <div class=\'input-group-btn\'>\n" +
                "       {browse}\n" +
                "   </div>\n" +
                "   {caption}\n" +
                "</div>"
            },
            initialPreviewAsData: true,
            allowedFileExtensions: ["jpg", "gif", "png", "txt", "pdf", "rar"]

        });
    })

    $(element).find('[select="next"]').each(function(){
       if(!empty($(this).val())){
           find_elemento(element,$(this))
       }
        $(this).change(function(){
            find_elemento(element,$(this))
        })
    });

}

function find_elemento(element,input){
    var auxiliar = $(input).attr('id')
    var valor_auxiliar = $(input).val()
    var campo = $(input).attr('campo')
    console.log(campo)
    $(element).find("#"+campo).each(function(){
        var model = $(this).attr('model')
        var coluna = $(this).attr('coluna')
        var tomany = $(this).attr('tomany')
        var valor_update = $(this).attr('valor_update')
        if(empty(valor_auxiliar)){
            return false;
        }
        $.ajax({
            type:'GET',
            url:SITE_PATH+"/busca_options",
            data:{
                auxiliar: auxiliar,
                valor_auxiliar: valor_auxiliar,
                model: model,
                coluna:coluna,
                tomany:tomany,
                valor_update:valor_update
            },
            success:function(txt){
                $("#"+campo).html(txt).trigger('change')
            }
        })
    })
}
function last_modal() {
    var maior = 0;
    $(".modal").each(function (key, value) {
        if ($(this).hasClass('in')) {
            if (parseInt($(this).attr('data-modal-index')) > parseInt(maior)) {
                maior = $(this).attr('data-modal-index');
            }
        }
    })
    return maior;
}

function modal_ativa() {
    var maior = 0;
    var modal = null;
    $(".modal").each(function (key, value) {
        if ($(this).hasClass('in')) {
            if (parseInt($(this).attr('data-modal-index')) > parseInt(maior)) {
                maior = $(this).attr('data-modal-index');
                modal = $(this)
            }
        }
    })
    return modal;
}

function limpar_modais() {
    $(".modal").each(function (key, value) {
        if (!$(this).hasClass('in')) {
            var html = '<div style="text-align:center"><img width="200" src="' + SITE_PATH + '/img/loading.gif"></div>';
            $(this).find('.modal-content').html(html);
        }
    });
}

function change_photo(form) {
    var modal = modal_ativa();
    var documento = $(modal).find('.modal-content');

    $('form#' + form).ajaxForm({
        beforeSend: function () {
            $(documento).find(".progress").show();
            var percentVal = '0%';
            $(documento).find(".percent").text(percentVal)
            $(documento).find("[role='progressbar']").attr('style', 'width: ' + percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            $(documento).find("[role='progressbar']").attr('style', 'width: ' + percentVal);
        },
        success: function (d) {
            if (d.res == 1) {
                swal({
                    title: "Sucesso!",
                    text: "Imagem alterada com sucesso",
                    type: "success"
                }, function () {
                    $("#user-image").attr('src', SITE_PATH + '/storage/' + d.imagem)
                    $(modal).modal('hide')
                })
            } else {
                swal("Alerta!", "Erro ao salvar imagem!", "danger")
                return false;
            }
        }
    });
}

function change_senha(form) {
    var modal = modal_ativa();
    var documento = $(modal).find('.modal-content');

    $('form#' + form).ajaxForm({
        success: function (d) {
            if (d.res == 1) {
                swal({
                    title: "Sucesso!",
                    text: "Senha alterada com sucesso",
                    type: "success"
                }, function () {
                    $(modal).modal('hide')
                })
            } else {
                swal("Alerta!", "Erro ao salvar senha!", "danger")
                return false;
            }
        },
        error: function (data) {
            $('#erros_ajax').html('');
            if (data.status === 422) {
                $.each(data.responseJSON, function (key, value) {
                    if(!empty(value.senha)){
                        $.each(value.senha, function (k, v) {
                            $(documento).find('#erros_ajax').append('<div class="alert alert-danger"><p>* ' + v + '</p></div>');
                        });
                    }
                });
            }
        }
    });
}

const NavObject = {"navegacao": [{"p": 1, "u": SITE_PATH}]};

function recarregar() {
    var pos = NavObject.navegacao.length;
    var res = parseInt(pos) - 1;
    var caminho = NavObject.navegacao[res].u;

    var modal = modal_ativa();
    var documento = $(modal).find('.modal-content');
    $(documento).find(".this-place").loadGrid(caminho, null, ".this-place", carregar);

}

function Acrescentar(url) {
    var pos = NavObject.navegacao.length;
    var add = true;
    $.when(
        $.each(NavObject, function (key, data) {
            $.each(data, function (id, valor) {
                if (valor.u == url) {
                    add = false;
                }
            })
        })
    ).then(function () {
        if (add) {
            pos = pos + 1;
            var url2 = {"p": pos, "u": url};
            NavObject.navegacao.push(url2);
        }
    })

}

function Decrementar(url, param) {
    NavObject.navegacao.pop();
    Navegar(url, param);
}

function Navegar(url, param) {
    var pos = NavObject.navegacao.length;
    if (param == 'go') {
        var url2 = {"p": pos, "u": url};
        NavObject.navegacao.push(url2);
    } else {
        pos = pos - 1;
        NavObject.navegacao.pop();
    }

    var modal = modal_ativa();
    var documento = $(modal).find('.modal-content');

    if (pos == 1) {
        modal.modal('hide');
    } else{
        if(param=='go'){
            $(documento).find(".this-place").loadGrid(url, null, ".this-place", carregar);
        }else {
            var ultimo = $(NavObject.navegacao).get(-1);
            $(documento).find(".this-place").loadGrid(ultimo.u, null, ".this-place", carregar);
        }
    }

}

function initModal(documento) {
    form_campos(documento);
    $(documento).on('click', 'button:submit', function (event) {
        event.preventDefault();
        if (empty($(this).attr('onclick')) && empty($(this).attr('listen'))) {
            SendForm(documento.find('form'));
            return false;
        }
    });

    $(documento).on('click', 'input:submit', function (event) {
        event.preventDefault();

        if (empty($(this).attr('onclick')) && empty($(this).attr('listen'))) {
            SendForm(documento.find('form'));
            return false;
        }
    });

    $(documento).on('click', 'button#btn-voltar', function (event) {
        event.preventDefault();
        console.log("button#btn-voltar")
        Navegar('', 'back')
        return false;
    });
    $(documento).on('click', "a#btn-voltar", function (event) {
        event.preventDefault();
        console.log("a#btn-voltar")
        Navegar('', 'back')
        return false;
    });

    $(documento).on('click', "a", function (event) {
        event.preventDefault();
        if (empty($(this).attr('listen'))) {
            if (!empty($(this).attr('id'))) {
                switch ($(this).attr('id')) {
                    case 'btn-excluir':
                        deletar($(this).attr('data-texto'), $(this).attr('href'))
                        break;
                    default:
                        if (!empty(this.href)) {
                            Navegar(this.href, 'go');
                        }
                        break;
                }
            } else if (!empty(this.href)) {
                console.log(this.href)
                Navegar(this.href, 'go');
            }
            return false;
        }
        return false;
    });


    $(documento).find(".paginator a").click(function () {
        var caminho = this.href;
        console.log(caminho)
        var form = $(documento).find('form').serializeObject();
        $(documento).find("div.table-responsive").loadGrid(caminho, form, null, carregar);
        return false;
    })
    $(documento).find("#btn-filter").each(function () {
        $(this).click(function () {
            if (!empty(auxiliares.click)) {
                return false;
            }
            auxiliares.click = 1;
            var caminho = $(documento).find('form').attr('action');


            var form = $(documento).find('form').serializeObject();
            $(documento).find('.table-responsive').loadGrid(caminho, form, null, carregar);
            return false;
        })
    })

    $(documento).find("#btn-limpar-pesquisa").each(function () {
        $(this).click(function () {
            if (!empty(auxiliares.click)) {
                return false;
            }
            recarregar();
            return false;
        })
    })
}

function deletar(texto, url) {
    swal({
        title: 'Confirmação',
        text: texto,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
    }, function () {
        var form = $("<form/>",
            {
                action: url,
                method: 'POST',
                style: 'display:none'
            }
        );
        form.append(
            $("<input>",
                {
                    type: 'text',
                    name: '_method',
                    value: 'DELETE'
                }
            )
        );
        form.append(
            $("<input>",
                {
                    type: 'text',
                    name: '_token',
                    value: $('meta[name="_token"]').attr('content')
                }
            )
        );
        $('#form-delete').append(form);
        SendFormRecarregar(form);
    });
}

function deletar_tabs(texto, url) {
    swal({
        title: 'Confirmação',
        text: texto,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
    }, function () {
        var form = $("<form/>",
            {
                action: url,
                method: 'POST',
                style: 'display:none'
            }
        );
        form.append(
            $("<input>",
                {
                    type: 'text',
                    name: '_method',
                    value: 'DELETE'
                }
            )
        );
        form.append(
            $("<input>",
                {
                    type: 'text',
                    name: '_token',
                    value: $('meta[name="_token"]').attr('content')
                }
            )
        );
        $('#form-delete').append(form);
        FormAbas(form);
    });

}

function SendForm(form) {
    $(form).ajaxForm({
        beforeSubmit: function () {
            console.log('SendForm')
            LoadGif()
        },
        success: function (txt) {
            CloseGif();
            Navegar('', 'back');
        },
        error: function (data) {
            CloseGif();
            var erros = "";
            if (data.status === 422) {
                $.each(data.responseJSON, function (key, value) {
                    erros += "<p>* ' + value + '</p>"
                });
            }
            swal("Alerta!", erros, "error")
        }
    }).submit();
    return false;
}

function SendFormRecarregar(form) {
    $(form).ajaxForm({
        beforeSubmit: function () {
            console.log('SendFormRecarregar')
            LoadGif()
        },
        success: function (txt) {
            CloseGif();
            recarregar();
        },
        error: function (data) {
            CloseGif();
            var erros = "";
            if (data.status === 422) {
                $.each(data.responseJSON, function (key, value) {
                    erros += "<p>* ' + value + '</p>"
                });
            }
            swal("Alerta!", erros, "error")
        }
    }).submit();
}

function FormAbas(form) {
    $(form).ajaxForm({
        beforeSubmit: function () {
            LoadGif()
        },
        success: function (txt) {
            CloseGif();
            $("#link-tabs").find('.active a').click()
        },
        error: function (data) {
            CloseGif();
            var erros = "";
            if (data.status === 422) {
                $.each(data.responseJSON, function (key, value) {
                    erros += value + "\r"
                });
            }
            swal("Alerta!", erros, "error")
            auxiliares.click=null;
        }
    }).submit();
}

function carregar() {
    var modal = modal_ativa();
    if (!empty(modal)) {
        var documento = $(modal).find('.modal-content');
        initModal(documento)
        sistema.aplicarPluginsExternos(documento);
        auxiliares.click = null;
        auxiliares.filter = null;
    }

}

function LoadGif() {
    var div = document.createElement("div");
    div.setAttribute('id', 'dialog-cep');
    var img = document.createElement("img");
    img.setAttribute("src", SITE_PATH + "/img/WindowsPhoneProgressbar.gif");
    div.appendChild(img);
    document.body.appendChild(div);
    $("#dialog-cep").css({
        "position": "fixed",
        "top": "0",
        "right": "0",
        "bottom": "0",
        "left": "0",
        "z-index": "2210",
        "background-color": "#000000",
        "opacity": "0.8",
        "filter": "alpha(opacity=80)"
    });

    $("#dialog-cep img").css({
        "position": "fixed",
        "top": "40%",
        "left": "30%"
    });
}

function CloseGif() {
    $("#dialog-cep").remove();
    $(".numero").focus();
}