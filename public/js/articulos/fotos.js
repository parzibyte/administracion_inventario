/*
 *     Copyright (C) 2019  Luis Cabrera Benito a.k.a. parzibyte
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */
new Vue({
    el: "#app",
    data: () => ({
        fotos: [],
    }),
    methods: {
        onFotosCambiadas() {
            // Copiar el arreglo de fotos, ya que es inmutable de manera original
            this.fotos = Array.from(this.$refs.fotos.files);
        },
        eliminar(ruta) {
            if (!confirm("¿Realmente deseas eliminar la foto?")) return;
            HTTP
                .post("/eliminar/foto/articulo", {
                    nombre: ruta
                })
                .then(() => {
                    window.location.reload();
                });
        },
    }
});