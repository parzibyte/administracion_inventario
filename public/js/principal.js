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


const manejarError = error => {
    //TODO: hacer algo con el error
};
const HTTP = {
    get(ruta) {
        return fetch(URL_BASE_API + ruta)
            .then(respuesta => respuesta.json())
            .catch(error => {
                manejarError(error);
            })
    },
    post(ruta, objeto) {
        return fetch(URL_BASE_API + ruta, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': TOKEN_CSRF,
            },
            body: JSON.stringify(objeto)
        })
            .then(respuesta => respuesta.json())
            .catch(error => {
                manejarError(error);
            })
    },
    put(ruta, objeto) {
        return fetch(URL_BASE_API + ruta, {
            method: "PUT",
            headers: {
                'X-CSRF-TOKEN': TOKEN_CSRF,
            },
            body: JSON.stringify(objeto),
        })
            .then(respuesta => respuesta.json())
            .catch(error => {
                manejarError(error);
            })
    },
    delete(ruta) {
        return fetch(URL_BASE_API + ruta, {
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': TOKEN_CSRF,
            },
        })
            .then(respuesta => respuesta.json())
            .catch(error => {
                manejarError(error);
            })
    }
};