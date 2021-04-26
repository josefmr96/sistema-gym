<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

  Route::group(array('domain' => '127.0.0.1'), function()
{

Route::get('/', 'ControladorGymHome@index');
Route::get('/nosotros', 'ControladorGymNosotros@index');
Route::get('/clases', 'ControladorGymClases@index');
Route::get('/servicios', 'ControladorGymServicios@index');
Route::get('/entrenadores', 'ControladorGymEntrenadores@index');
Route::get('/contacto', 'ControladorGymContacto@index');
Route::get('/entrenador/{id}', 'ControladorGymEntrenador@index');
Route::post('/contacto', 'ControladorGymContacto@submit');


Route::get('/admin', 'ControladorHome@index');
Route::get('/admin/legajo', 'ControladorLegajo@index');


Route::get('/admin/home', 'ControladorHome@index');

/* --------------------------------------------- */
/* CONTROLADOR LOGIN                           */
/* --------------------------------------------- */
Route::get('/admin/login', 'ControladorLogin@index');
Route::get('/admin/logout', 'ControladorLogin@logout');
Route::post('/admin/logout', 'ControladorLogin@entrar');
Route::post('/admin/login', 'ControladorLogin@entrar');


/* --------------------------------------------- */
/* CONTROLADOR RECUPERO CLAVE                    */
/* --------------------------------------------- */
Route::get('/admin/recupero-clave', 'ControladorRecuperoClave@index');
Route::post('/admin/recupero-clave', 'ControladorRecuperoClave@recuperar');

/* --------------------------------------------- */
/* CONTROLADOR PERMISO                           */
/* --------------------------------------------- */
Route::get('/admin/usuarios/cargarGrillaFamiliaDisponibles', 'ControladorPermiso@cargarGrillaFamiliaDisponibles')->name('usuarios.cargarGrillaFamiliaDisponibles');
Route::get('/admin/usuarios/cargarGrillaFamiliasDelUsuario', 'ControladorPermiso@cargarGrillaFamiliasDelUsuario')->name('usuarios.cargarGrillaFamiliasDelUsuario');
Route::get('/admin/permisos', 'ControladorPermiso@index');
Route::get('/admin/permisos/cargarGrilla', 'ControladorPermiso@cargarGrilla')->name('permiso.cargarGrilla');
Route::get('/admin/permiso/nuevo', 'ControladorPermiso@nuevo');
Route::get('/admin/permiso/cargarGrillaPatentesPorFamilia', 'ControladorPermiso@cargarGrillaPatentesPorFamilia')->name('permiso.cargarGrillaPatentesPorFamilia');
Route::get('/admin/permiso/cargarGrillaPatentesDisponibles', 'ControladorPermiso@cargarGrillaPatentesDisponibles')->name('permiso.cargarGrillaPatentesDisponibles');
Route::get('/admin/permiso/{idpermiso}', 'ControladorPermiso@editar');
Route::post('/admin/permiso/{idpermiso}', 'ControladorPermiso@guardar');

/* --------------------------------------------- */
/* CONTROLADOR GRUPO                             */
/* --------------------------------------------- */
Route::get('/admin/grupos', 'ControladorGrupo@index');
Route::get('/admin/usuarios/cargarGrillaGruposDelUsuario', 'ControladorGrupo@cargarGrillaGruposDelUsuario')->name('usuarios.cargarGrillaGruposDelUsuario'); //otra cosa
Route::get('/admin/usuarios/cargarGrillaGruposDisponibles', 'ControladorGrupo@cargarGrillaGruposDisponibles')->name('usuarios.cargarGrillaGruposDisponibles'); //otra cosa
Route::get('/admin/grupos/cargarGrilla', 'ControladorGrupo@cargarGrilla')->name('grupo.cargarGrilla');
Route::get('/admin/grupo/nuevo', 'ControladorGrupo@nuevo');
Route::get('/admin/grupo/setearGrupo', 'ControladorGrupo@setearGrupo');
Route::post('/admin/grupo/nuevo', 'ControladorGrupo@guardar');
Route::get('/admin/grupo/{idgrupo}', 'ControladorGrupo@editar');
Route::post('/admin/grupo/{idgrupo}', 'ControladorGrupo@guardar');

/* --------------------------------------------- */
/* CONTROLADOR USUARIO                           */
/* --------------------------------------------- */
Route::get('/admin/usuarios', 'ControladorUsuario@index');
Route::get('/admin/usuarios/nuevo', 'ControladorUsuario@nuevo');
Route::post('/admin/usuarios/nuevo', 'ControladorUsuario@guardar');
Route::post('/admin/usuarios/{usuario}', 'ControladorUsuario@guardar');
Route::get('/admin/usuarios/cargarGrilla', 'ControladorUsuario@cargarGrilla')->name('usuarios.cargarGrilla');
Route::get('/admin/usuarios/buscarUsuario', 'ControladorUsuario@buscarUsuario');
Route::get('/admin/usuarios/{usuario}', 'ControladorUsuario@editar');

/* --------------------------------------------- */
/* CONTROLADOR MENU                              */
/* --------------------------------------------- */
Route::get('/admin/sistema/menu', 'ControladorMenu@index');
Route::get('/admin/sistema/menu/nuevo', 'ControladorMenu@nuevo');
Route::post('/admin/sistema/menu/nuevo', 'ControladorMenu@guardar');
Route::get('/admin/sistema/menu/cargarGrilla', 'ControladorMenu@cargarGrilla')->name('menu.cargarGrilla');
Route::get('/admin/sistema/menu/eliminar', 'ControladorMenu@eliminar');
Route::get('/admin/sistema/menu/{id}', 'ControladorMenu@editar');
Route::post('/admin/sistema/menu/{id}', 'ControladorMenu@guardar');



/* --------------------------------------------- */
/* CONTROLADOR ALUMNOS                           */
/* --------------------------------------------- */

Route::get('/admin/alumno/nuevo', 'ControladorAlumnos@nuevo');
Route::post('/admin/alumno/nuevo', 'ControladorAlumnos@guardar');
Route::get('/admin/alumno/alumnos', 'ControladorAlumnos@index');
Route::get('/admin/alumno/alumnos/cargarGrilla', 'ControladorAlumnos@cargarGrilla')->name('alumnos.cargarGrilla');
Route::get('/admin/alumno/fichamedica/{id}', 'ControladorFichaMedica@editar');
Route::post('/admin/alumno/fichamedica/{id}', 'ControladorFichaMedica@guardar');
Route::post('/admin/alumno/dieta/{id}', 'ControladorDieta@guardar');
Route::get('/admin/alumno/dieta/{id}', 'ControladorDieta@editar');
Route::get('/admin/alumno/eliminar', 'ControladorAlumnos@eliminar');
Route::get('/admin/alumno/{id}', 'ControladorAlumnos@editar');
Route::post('/admin/alumno/{id}', 'ControladorAlumnos@guardar');


/* ---------------------------------------------  */
/*CONTROLADOR DIETA                               */
/* --------------------------------------------- */
Route::get('/alumno/dieta', 'ControladorDieta@index');
/*Route::post('/dieta/nuevo', 'ControladorDieta@guardar');*/
/*Route::post('/admin/dieta/nuevo', 'ControladorDieta@guardar');*/


/* --------------------------------------------- */
/* CONTROLADOR COBROS                            */
/* --------------------------------------------- */

Route::get('/admin/cobros/nuevo', 'ControladorCobros@nuevo');
Route::post('/admin/cobros/nuevo', 'ControladorCobros@guardar');
Route::get('/admin/cobros', 'ControladorCobros@index');
Route::get('/admin/cobros/cargarGrilla', 'ControladorCobros@cargarGrilla')->name('cobros.cargarGrilla');
Route::get('/admin/cobros/{id}', 'ControladorCobros@editar');
Route::post('/admin/cobros/{id}', 'ControladorCobros@guardar');


/* --------------------------------------------- */
/* CONTROLADOR PAGOS                             */
/* --------------------------------------------- */

Route::get('/admin/pagos/nuevo', 'ControladorPagos@nuevo');
Route::post('/admin/pagos/nuevo', 'ControladorPagos@guardar');
Route::get('/admin/pagos', 'ControladorPagos@index');
Route::get('/admin/pagos/cargarGrilla', 'ControladorPagos@cargarGrilla')->name('pagos.cargarGrilla');
Route::get('/admin/pagos/{id}', 'ControladorPagos@editar');
Route::post('/admin/pagos/{id}', 'ControladorPagos@guardar');

/* CONTROLADOR CONDICIONIVA NUEVO                             */
/* --------------------------------------------- */
Route::get('/admin/configuracion/condicioniva/', 'ControladorCondicionIva@nuevo');
Route::post('/admin/configuracion/condicioniva/', 'ControladorCondicionIva@guardar');
Route::get('/admin/condicioniva', 'ControladorCondicionIva@index');
Route::get('/admin/condicioniva/cargarGrilla', 'ControladorCondicionIva@cargarGrilla')->name('condicioniva.cargarGrilla');
Route::get('/admin/condicioniva/eliminar', 'ControladorCondicionIva@eliminar');
Route::get('/admin/condicioniva/{id}', 'ControladorCondicionIva@editar');
Route::post('/admin/condicioniva/{id}', 'ControladorCondicionIva@guardar');
/* --------------------------------------------- */
/* CONTROLADOR MONEDAS                        */
/* --------------------------------------------- */
Route::get('/admin/monedas/nuevo/', 'ControladorMonedas@nuevo');
Route::post('/admin/monedas/nuevo/', 'ControladorMonedas@guardar');
Route::get('/admin/monedas', 'ControladorMonedas@index');
Route::get('/admin/monedas/cargarGrilla', 'ControladorMonedas@cargarGrilla')->name('monedas.cargarGrilla');
Route::get('/admin/monedas/eliminar', 'ControladorMonedas@eliminar');
Route::get('/admin/monedas/{id}', 'ControladorMonedas@editar');
Route::post('/admin/monedas/{id}', 'ControladorMonedas@guardar');


/* --------------------------------------------- */
/* CONTROLADOR ENTRENADORES                        */
/* --------------------------------------------- */
Route::get('/admin/entrenador/nuevo', 'ControladorEntrenadores@nuevo');
Route::post('/admin/entrenador/nuevo', 'ControladorEntrenadores@guardar');
Route::get('/admin/entrenadores', 'ControladorEntrenadores@index');
Route::get('/admin/entrenadores/cargarGrilla', 'ControladorEntrenadores@cargarGrilla')->name('entrenadores.cargarGrilla');
Route::get('/admin/entrenadores/eliminar', 'ControladorEntrenadores@eliminar');
Route::get('/admin/entrenador/{id}', 'ControladorEntrenadores@editar');
Route::post('/admin/entrenador/{id}', 'ControladorEntrenadores@guardar');



/* CONTROLADOR PRODUCTO                             */
/* --------------------------------------------- */
Route::get('/admin/producto/nuevo', 'ControladorProducto@nuevo');
Route::get('/admin/producto/categorias/nuevo', 'ControladorCategoria@nuevo');
Route::post('/admin/producto/categorias/nuevo', 'ControladorCategoria@guardar');
Route::get('/admin/producto/categorias', 'ControladorCategoria@index');
Route::get('/admin/producto/categorias/cargarGrilla', 'ControladorCategoria@cargarGrilla')->name('categoria.cargarGrilla');
Route::get('/admin/categoria/{id}', 'ControladorCategoria@editar');
Route::post('/admin/categoria/{id}', 'ControladorCategoria@guardar');
Route::post('/admin/producto/nuevo', 'ControladorProducto@guardar');
Route::get('/admin/producto/categoria/nuevo', 'ControladorCategoria@nuevo');
Route::post('/admin/producto/categorias/nuevo', 'ControladorCategoria@guardar');
Route::get('/admin/productos', 'ControladorProducto@index');
Route::get('/admin/producto/cargarGrilla', 'ControladorProducto@cargarGrilla')->name('producto.cargarGrilla');
Route::get('/admin/producto/eliminar', 'ControladorProducto@eliminar');
Route::get('/admin/producto/{id}', 'ControladorProducto@editar');
Route::post('/admin/producto/{id}', 'ControladorProducto@guardar');

/* CONTROLADOR MEDIOS DE PAGO*/
Route::get('/admin/configuracion/mediosdepago', 'ControladorMediosDePago@nuevo');
Route::post('/admin/configuracion/mediosdepago', 'ControladorMediosDePago@guardar');
Route::get('/admin/configuracion/mediosdepago-listar', 'ControladorMediosDePago@index');
Route::get('/admin/configuracion/mediosdepago/cargarGrilla', 'ControladorMediosDePago@cargarGrilla')->name('mediosdepago.cargarGrilla');
Route::get('/admin/configuracion/mediosdepago/nuevo', 'ControladorMediosDePago@nuevo');
Route::post('/admin/configuracion/mediosdepago/nuevo', 'ControladorMediosDePago@guardar');
Route::get('/admin/configuracion/mediosdepago', 'ControladorMediosDePago@index');
Route::get('/admin/configuracion/mediosdepago/{id}', 'ControladorMediosDePago@editar');
Route::post('/admin/configuracion/mediosdepago/{id}', 'ControladorMediosDePago@guardar');

});


