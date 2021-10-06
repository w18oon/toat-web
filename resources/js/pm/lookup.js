import {instance} from "./httpClient";
import {$route} from './router'

export const query = {
    on: function (table) {
        //console.log('lookup query', table)
        return typeof this[table] === 'undefined' ? this.index(table) : this[table]
    },
    index: (table) => {
        return {
            id: (id, idField, lookupField) => instance.get($route('api.pm.lookup', {table}), {
                params: {
                    id,
                    idField,
                    lookupField,
                }
            }),
            search: (q, idField, lookupField, payload) => instance.get($route('api.pm.lookup', {table}), {
                params: {
                    q,
                    idField,
                    lookupField,
                    payload,
                }
            }),
        }
    },
    //ptinvItemcatMatgroupV: (q, f = 'meaning') => instance.get('/api/pm/lookup/PtinvItemcatMatgroupV', {params: {q, f}}),
}


export const queryPD = {
    on: function (table) {
        //console.log('lookup query', table)
        return typeof this[table] === 'undefined' ? this.index(table) : this[table]
    },
    index: (table) => {
        return {
            id: (id, idField, lookupField) => instance.get($route('api.pd.lookup', {table}), {
                params: {
                    id,
                    idField,
                    lookupField,
                }
            }),
            search: (q, idField, lookupField, payload) => instance.get($route('api.pd.lookup', {table}), {
                params: {
                    q,
                    idField,
                    lookupField,
                    payload,
                }
            }),
        }
    },
    //ptinvItemcatMatgroupV: (q, f = 'meaning') => instance.get('/api/pm/lookup/PtinvItemcatMatgroupV', {params: {q, f}}),
}
