<template>
    <li>
        <div class="switch">
            <ui-switch :value.sync="todo.completed"></ui-switch>
        </div>
        {{ todo.name }}
        <div class="control">
            <ui-icon icon="mode_edit"
                @click="editTodo(todo)"></ui-icon>
            <ui-icon icon="delete_forever"
                @click="removeTodo(todo)"
            ></ui-icon>
        </div>
    </li>
</template>

<script>
    import laroute from '../../laroute';
    import alertify from 'alertify.js';

    export default {
        props: {
            todo: {
                type: Object,
                required: true
            }
        },

        watch: {
            todo: {
                deep:true,
                handler(val, old) {
                    this.$http.put(laroute.route('api.todo.update', { todo: val.id }), val).then(res => {
                        //update success: completed, name
                    }).catch(({ status, data, statusText }) => {
                        status === 422 && (statusText = data[Object.keys(data)[0]]);
                        alertify.delay(0).error(statusText);
                        this.$parent.reloadAsyncData();
                    });
                }
            }
        },

        methods: {
            editTodo(todo) {
                alertify
                    .defaultValue(todo.name)
                    .prompt("Edit todo", (val) => {
                        this.todo.name = val.trim();
                    });
            },
            removeTodo(todo) {
                alertify.confirm("Are you sure remove todo?",  () =>  {
                    this.$http.delete(laroute.route('api.todo.destroy', { todo: todo.id })).then(res => {
                        //delete success
                        this.$dispatch('remove-todo', todo);
                    }).catch(res => {
                        alertify.delay(0).error("Cannot remove todo");
                    });
                });
            }
        }
    }

</script>