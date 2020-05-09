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

use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect()->to("/login");
});
//-------------------------------
// Áreas
//-------------------------------


Route::group(
    [
        "middleware" => [
            "auth"
        ]
    ],
    function () {

        # API
        Route::prefix("api")
            ->group(function () {
                // Áreas
                Route::get("areas", "AreasController@mostrar");
                Route::get("areas/buscar/{busqueda}", "AreasController@buscar");
                Route::delete("area/{id}", "AreasController@eliminar");
                Route::post("areas/eliminar", "AreasController@eliminarMuchas");
                // Responsables
                Route::post("/responsable", "ResponsablesController@agregar");
                Route::get("responsables", "ResponsablesController@mostrar");
                Route::get("responsable/{id}", "ResponsablesController@porId");
                Route::get("responsables/buscar/{busqueda}", "ResponsablesController@buscar");
                Route::delete("responsable/{id}", "ResponsablesController@eliminar");
                Route::post("responsables/eliminar", "ResponsablesController@eliminarMuchos");
                Route::put("responsable/", "ResponsablesController@guardarCambios")->name("guardarCambiosDeResponsable");
                // Artículos
                Route::post("/articulo", "ArticulosController@agregar");
                Route::get("/articulos", "ArticulosController@mostrar");
                Route::get("articulo/{id}", "ArticulosController@porId");
                Route::put("articulo/", "ArticulosController@guardarCambios")->name("guardarCambiosDeResponsable");
                // Fotos de artículos
                Route::post("eliminar/foto/articulo/", "ArticulosController@eliminarFoto")->name("eliminarFotoDeArticulo");

            });


        # VISTAS
        Route::view("areas/agregar", "agregar_area")->name("formularioArea");
        Route::get("areas/editar/{id}", "AreasController@editar")->name("formularioEditarArea");
        Route::view("areas/", "areas")->name("areas");
        # Otras cosas
        Route::post("areas/agregar", "AreasController@agregar")->name("guardarArea");
        Route::put("area/", "AreasController@guardarCambios")->name("guardarCambiosDeArea");

        Route::get("foto/articulo/{nombre}", "ArticulosController@foto")->name("fotoDeArticulo");
        Route::get("descargar/foto/articulo/{nombre}", "ArticulosController@descargar")->name("descargarFotoDeArticulo");


        //-------------------------------
        // Responsables
        //-------------------------------
        Route::view("responsables/agregar", "responsables/agregar")->name("formularioAgregarResponsable");
        Route::view("responsables/", "responsables/mostrar")->name("responsables");
        Route::view("responsables/editar/{id}", "responsables/editar")->name("formularioEditarResponsable");
        //-------------------------------
        // Artículos
        //-------------------------------
        Route::view("articulos/agregar", "articulos.agregar")->name("formularioAgregarArticulo");
        Route::view("articulos/", "articulos/mostrar")->name("articulos");
        Route::view("articulos/editar/{id}", "articulos/editar")->name("formularioEditarArticulo");
        Route::get("articulos/fotos/{id}", "ArticulosController@administrarFotos")->name("administrarFotos");
        Route::get("articulos/eliminar/{id}", "ArticulosController@vistaDarDeBaja")->name("vistaDarDeBajaArticulo");
        Route::post("articulos/fotos", "ArticulosController@agregarFotos")->name("agregarFotosDeArticulo");
        Route::post("articulos/eliminar", "ArticulosController@eliminar")->name("eliminarArticulo");

        # Logout
        Route::get("logout", function () {
            Auth::logout();
            # Intentar redireccionar a una protegida, que a su vez redirecciona al login :)
            return redirect()->route("articulos");
        })->name("logout");
    });


Auth::routes(["register" => false]);

Route::get('/home', 'HomeController@index')->name('home');
