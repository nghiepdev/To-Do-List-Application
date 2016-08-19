<template>
    <ui-textbox
        name="todo"
        placeholder="What need to be done?"
        :autofocus="true"
        :value.sync="inputTodo"
        @keydown-enter="addTodo"
    ></ui-textbox>

    <div v-if="$loadingAsyncData">
        <loading></loading>
    </div>
    <div v-else>
        <ul>
            <todo
                v-for="todo in todos | filterBy filterValue in 'completed'"
                :todo="todo"
            ></todo>
        </ul>
        <section class="todos-footer">

            <div class="row">
                <div class="col-xs-3 count-active">
                    <span>{{ countActive }} {{ countActive  | pluralize 'item'}} left</span>
                </div>
                <div class="col-xs-9 todos-filter">
                    <span @click="setFilter('all')" :class="{actived: filter === 'all'}">All</span>
                    <span @click="setFilter('active')" :class="{actived: filter === 'active'}">Active</span>
                    <span @click="setFilter('completed')" :class="{actived: filter === 'completed'}">Completed</span>
                </div>
            </div>

        </section>
    </div>

</template>

<script>
    import alertify from 'alertify.js';
    import laroute from '../../laroute';
    import Todo from './Todo.vue';
    import Loading from '../Loading.vue';

    export default {

        data: () => ({
            todos: [],
            filter: 'all',
            inputTodo: ''
        }),

        asyncData(resolve, reject) {
            this.$http.get(laroute.route('api.todo.index')).then(({ data }) => {
                resolve({todos: data});
            }).catch(res => {
                alertify.error("Error load todos from server");
            });
        },

        computed: {
            filterValue() {
                if(this.filter === 'all') {
                    return '';
                }
                return this.filter === 'active' ?  false : true;
            },
            countActive() {
                return this.todos.filter(todo => !todo.completed).length;
            }
        },

        methods: {
            setFilter(filter) {
                this.filter = filter;
            },
            addTodo() {
                this.$http.post(laroute.route('api.todo.store'), { name: this.inputTodo, completed: false }).then(({ data }) => {
                    // add todo success
                    this.todos.unshift(data);
                    this.inputTodo = '';
                }).catch(({ status, data, statusText }) => {
                    status === 422 && (statusText = data[Object.keys(data)[0]]);
                    alertify.delay(0).error(statusText);
                });
            }
        },

        components: {
            Todo, Loading
        },

        events: {
            'remove-todo'(todo) {
                this.todos.$remove(todo);
            }
        }
    }

</script>