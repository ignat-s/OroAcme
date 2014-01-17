/*jslint nomen: true, vars: true*/
/*global define*/

define(['jquery', 'underscore', 'backbone', 'routing', 'oro/loading-mask'],
    function ($, _, Backbone, routing, LoadingMask) {

    'use strict';

    /**
     * @export acmetask/sidebar/widget/assigned_tasks
     */
    var tasks = {};

    var TaskView = Backbone.View.extend({
        tagName: 'li',

        iconStatusMap: {
            open: 'icon-folder-open-alt',
            in_progress: 'icon-play',
            closed: 'icon-ok'
        },

        template: _.template(
            '<i class="<%= iconClass %>"></i><a href="<%= routing.generate("acme_task_view", {id: id}) %>"><%= title %></a>'
        ),

        render: function () {
            this.$el.append(this.template(_.extend(
                this.model.toJSON(),
                {
                    routing: routing,
                    iconClass: this.getTaskIcon(this.model)
                }
            )));
            return this;
        },

        getTaskIcon: function(model) {
            var status = model.get('status');
            return _.has(this.iconStatusMap, status) ? this.iconStatusMap[status] : iconStatusMap.open;
        }
    });

    var TaskModel = Backbone.Model.extend({
        defaults: {
            id: null,
            title: '',
            status: ''
        }
    });

    var TasksCollection = Backbone.Collection.extend({
        model: TaskModel
    });

    tasks.ContentView = Backbone.View.extend({
        tasksCollection: new TasksCollection(),

        initialize: function () {
            var view = this;
            view.listenTo(this.tasksCollection, 'reset', view.renderCollection);
            view.listenTo(view.model, 'change', view.loadTasks);
        },

        loadTasks: function() {
            var settings = this.model.get('settings');
            this.tasksCollection.url = routing.generate('acme_api_get_task_assigned_tasks', {perPage: settings.perPage});
            this.tasksCollection.fetch({reset: true});
        },

        render: function () {
            var settings = this.model.get('settings');

            this.tasksCollection.url = routing.generate('acme_api_get_task_assigned_tasks', {perPage: settings.perPage});
            this.tasksCollection.fetch({reset: true});

            this.loadingMask = new LoadingMask();
            this.$el.append(this.loadingMask.render().$el);
            this.loadingMask.show();

            return this;
        },

        renderCollection: function() {
            var view = this;
            view.$el.empty().addClass('acme-assigned-tasks');

            if (this.tasksCollection.length) {
                var list = $('<ul/>');
                this.tasksCollection.each(function(model) {
                    var task = new TaskView({model: model});
                    list.append(task.render().$el);
                });
                view.$el.append(list);
            } else {
                view.$el.append(_.template('<p><%= _.__("acme.task.assigned_tasks_widget.no_tasks") %></p>'));
            }
        }
    });

    tasks.SetupView = Backbone.View.extend({
        template: _.template(
            '<h3><%= _.__("acme.task.assigned_tasks_widget.settings") %></h3>' +
            '<label for="perPage"><%= _.__("acme.task.assigned_tasks_widget.number_of_tasks") %></label>' +
            '<input type="text" name="perPage" value="<%= settings.perPage %>"/>'
        ),

        events: {
            'change [name="perPage"]': 'onChange'
        },

        render: function () {
            var view = this;
            view.$el.html(view.template(view.model.toJSON()));
            return view;
        },

        onChange: function (e) {
            var model = this.model;

            var perPage = this.$el.find('[name="perPage"]').val();

            var settings = model.get('settings');
            settings.perPage = perPage;

            model.set({ settings: settings }, { silent: true });
            model.trigger('change');
        }
    });

    return tasks;
});
