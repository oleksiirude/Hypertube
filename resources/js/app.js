/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// const _ = import('lodash');
import _ from 'lodash';
// Vue.prototype.trans = string => _.get(window.i18n, string);
//
Vue.filter ('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

// Vue.filter ('translit', function (str, typ) {
//     var func = (function(typ) {
//
//         function prep (a) {
//             var write = !a ? function(chr, row) {trantab[row] = chr;regarr.push(row);} :
//                 function(row, chr) {trantab[row] = chr;regarr.push(row);};
//             return function(col, row) {        // создаем таблицу и RegExp
//                 var chr = col[abs] || col[0];    // Символ
//                 if (chr) write(chr, row);        // Если символ есть
//             }
//         }
//         var abs = Math.abs(typ);             // Абсолютное значение транслитерации
//         if (typ === abs) {                   // Прямая транслитерация в латиницу
//             str = str.replace(/(i(?=.[^аеиоуъ\s]+))/ig, '$1`'); // "i`" ГОСТ ст. рус. и болг.
//             return [prep(),                    // Возвращаем массив функций
//                 function(str) {                  // str - транслируемая строка.
//                     return str.replace(/i``/ig, 'i`').    // "i`" в ГОСТ ст. рус. и болг.
//                     replace(/((c)z)(?=[ieyj])/ig, '$1'); // "cz" в символ "c"
//                 }];
//         } else {                             // Обратная транслитерация в кириллицу
//             str = str.replace(/(c)(?=[ieyj])/ig, '$1z'); // Правило сочетания "cz"
//             return [prep(1),function(str) {return str;}];// nop - пустая функция.
//         }
//     }(typ));
//     var iso9 = {                           // Объект описания стандарта
//         // Имя - кириллица
//         //   0 - общие для всех
//         //   1 - диакритика         4 - MK|MKD - Македония
//         //   2 - BY|BLR - Беларусь  5 - RU|RUS - Россия
//         //   3 - BG|BGR - Болгария  6 - UA|UKR - Украина
//         /*-Имя---------0-,-------1-,---2-,---3-,---4-,----5-,---6-*/
//         '\u0449': [   '', '\u015D',   '','sth',   '', 'shh','shh'], // 'щ'
//         '\u044F': [   '', '\u00E2', 'ya', 'ya',   '',  'ya', 'ya'], // 'я'
//         '\u0454': [   '', '\u00EA',   '',   '',   '',    '', 'ye'], // 'є'
//         '\u0463': [   '', '\u011B',   '', 'ye',   '',  'ye',   ''], //  ять
//         '\u0456': [   '', '\u00EC',  'i', 'i`',   '',  'i`',  'i'], // 'і' йота
//         '\u0457': [   '', '\u00EF',   '',   '',   '',    '', 'yi'], // 'ї'
//         '\u0451': [   '', '\u00EB', 'yo',   '',   '',  'yo',   ''], // 'ё'
//         '\u044E': [   '', '\u00FB', 'yu', 'yu',   '',  'yu', 'yu'], // 'ю'
//         '\u0436': [ 'zh','\u017E'],                                 // 'ж'
//         '\u0447': [ 'ch','\u010D'],                                 // 'ч'
//         '\u0448': [ 'sh', '\u0161',   '',   '',   '',    '',   ''], // 'ш'
//         '\u0473': [   '','f\u0300',   '', 'fh',   '',  'fh',   ''], //  фита
//         '\u045F': [   '','d\u0302',   '',   '', 'dh',    '',   ''], // 'џ'
//         '\u0491': [   '','g\u0300',   '',   '',   '',    '', 'g`'], // 'ґ'
//         '\u0453': [   '', '\u01F5',   '',   '', 'g`',    '',   ''], // 'ѓ'
//         '\u0455': [   '', '\u1E91',   '',   '', 'z`',    '',   ''], // 'ѕ'
//         '\u045C': [   '', '\u1E31',   '',   '', 'k`',    '',   ''], // 'ќ'
//         '\u0459': [   '','l\u0302',   '',   '', 'l`',    '',   ''], // 'љ'
//         '\u045A': [   '','n\u0302',   '',   '', 'n`',    '',   ''], // 'њ'
//         '\u044D': [   '', '\u00E8', 'e`',   '',   '',  'e`',   ''], // 'э'
//         '\u044A': [   '', '\u02BA',   '', 'a`',   '',  '``',   ''], // 'ъ'
//         '\u044B': [   '',      'y', 'y`',   '',   '',  'y`',   ''], // 'ы'
//         '\u045E': [   '', '\u01D4', 'u`',   '',   '',    '',   ''], // 'ў'
//         '\u046B': [   '', '\u01CE',   '', 'o`',   '',    '',   ''], //  юс
//         '\u0475': [   '', '\u1EF3',   '', 'yh',   '',  'yh',   ''], //  ижица
//         '\u0446': [ 'cz',     'c'],                                 // 'ц'
//         '\u0430': [ 'a'],                                           // 'а'
//         '\u0431': [ 'b'],                                           // 'б'
//         '\u0432': [ 'v'],                                           // 'в'
//         '\u0433': [ 'g'],                                           // 'г'
//         '\u0434': [ 'd'],                                           // 'д'
//         '\u0435': [ 'e'],                                           // 'е'
//         '\u0437': [ 'z'],                                           // 'з'
//         '\u0438': [   '',      'i',   '',  'i',  'i',   'i', 'y`'], // 'и'
//         '\u0439': [   '',      'j',  'j',  'j',   '',   'j',  'j'], // 'й'
//         '\u043A': [ 'k'],                                           // 'к'
//         '\u043B': [ 'l'],                                           // 'л'
//         '\u043C': [ 'm'],                                           // 'м'
//         '\u043D': [ 'n'],                                           // 'н'
//         '\u043E': [ 'o'],                                           // 'о'
//         '\u043F': [ 'p'],                                           // 'п'
//         '\u0440': [ 'r'],                                           // 'р'
//         '\u0441': [ 's'],                                           // 'с'
//         '\u0442': [ 't'],                                           // 'т'
//         '\u0443': [ 'u'],                                           // 'у'
//         '\u0444': [ 'f'],                                           // 'ф'
//         '\u0445': [  'x',     'h'],                                 // 'х'
//         '\u044C': [   '', '\u02B9',  '`',  '`',   '',   '`',  '`'], // 'ь'
//         '\u0458': [   '','j\u030C',   '',   '',  'j',    '',   ''], // 'ј'
//         '\u2019': [ '\'','\u02BC'],                                 // '’'
//         '\u2116': [  '#']                                           // '№'
//         /*-Имя---------0-,-------1-,---2-,---3-,---4-,----5-,---6-*/
//     }, regarr = [], trantab = {};
//     /* jshint -W030 */                     // Создание таблицы и массива RegExp
//     for (var row in iso9) {if (Object.hasOwnProperty.call(iso9, row)) {func[0](iso9[row], row);}}
//     /* jshint +W030 */
//     return func[1](                        // функция пост-обработки строки (правила и т.д.)
//         str.replace(                       // Транслитерация
//             new RegExp(regarr.join('|'), 'gi'),// Создаем RegExp из массива
//             function(R) {                      // CallBack Функция RegExp
//                 if (R.toLowerCase() === R) {     // Обработка строки с учетом регистра
//                     return trantab[R];
//                 } else {
//                     return trantab[R.toLowerCase()].toUpperCase();
//                 }
//             }));
// });

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};

Vue.component('registration-component', require('./components/Auth/RegistrationComponent').default);
Vue.component('login-component', require('./components/Auth/LoginComponent').default);
Vue.component('reset-password-email-component', require('./components/Auth/ResetPasswordEmailComponent').default);
Vue.component('reset-password-component', require('./components/Auth/ResetPasswordComponent').default);
Vue.component('footer-component', require('./components/layots/FooterComponent').default);
Vue.component('lang-component', require('./components/layots/LangComponentForMain').default);
Vue.component('avatar-component', require('./components/profile/AvatarComponent').default);
Vue.component('bio-component', require('./components/profile/BioComponent').default);
Vue.component('name-component', require('./components/profile/NameComponent').default);
Vue.component('email-component', require('./components/profile/EmailComponent').default);
Vue.component('paswword-component', require('./components/profile/PasswordComponent').default);
Vue.component('star-component', require('./components/movies/StarComponent').default);
Vue.component('search-component', require('./components/movies/SearchComponent').default);
Vue.component('sidebar-component', require('./components/movies/SideBarComponent').default);
Vue.component('actors-component', require('./components/one_movie_page/ActorsComponent').default);
Vue.component('genre-component', require('./components/one_movie_page/GenreComponent').default);
Vue.component('info-component', require('./components/one_movie_page/TitleInfoComponent').default);
Vue.component('trailer-component', require('./components/one_movie_page/TrailerComponent').default);
Vue.component('pagination-component', require('./components/Pagination/PaginationComponent').default);
Vue.component('comments-component', require('./components/one_movie_page/CommentsComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
