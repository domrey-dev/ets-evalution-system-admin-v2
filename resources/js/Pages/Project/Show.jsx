import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { Card, CardContent } from "@/Components/Card";
import {
  PROJECT_STATUS_CLASS_MAP,
  PROJECT_STATUS_TEXT_MAP,
} from "@/constants.jsx";
import TasksTable from "../Department/DepartmentTable";
import { 
  CalendarIcon, 
  UserIcon, 
  ClockIcon,
  DocumentTextIcon,
  PencilIcon,
  ChartBarIcon,
  FolderOpenIcon
} from "@heroicons/react/24/outline";

export default function Show({ auth, success, project, tasks, queryParams }) {
  const getStatusIcon = (status) => {
    switch (status) {
      case 'completed':
        return '✅';
      case 'in_progress':
        return '🔄';
      case 'pending':
        return '⏳';
      default:
        return '📋';
    }
  };

  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div className="flex items-center space-x-4">
            <div className="flex-shrink-0">
              <div className="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <FolderOpenIcon className="w-6 h-6 text-emerald-600" />
              </div>
            </div>
            <div>
              <h2 className="text-2xl font-bold text-gray-900">{project.name}</h2>
              <div className="flex items-center mt-1 space-x-4">
                <span
                  className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white ${
                    PROJECT_STATUS_CLASS_MAP[project.status]
                  }`}
                >
                  <span className="mr-1">{getStatusIcon(project.status)}</span>
                  {PROJECT_STATUS_TEXT_MAP[project.status]}
                </span>
                <span className="text-sm text-gray-500">Project #{project.id}</span>
              </div>
            </div>
          </div>
          <Link
            href={route("project.edit", project.id)}
            className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200"
          >
            <PencilIcon className="w-4 h-4 mr-2" />
            Edit Project
          </Link>
        </div>
      }
    >
      <Head title={`Project "${project.name}"`} />
      
      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
          {/* Success Message */}
          {success && (
            <div className="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg">
              {success}
            </div>
          )}

          {/* Project Overview */}
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {/* Project Image & Main Info */}
            <div className="lg:col-span-2">
              <Card className="overflow-hidden">
                {project.image_path && (
                  <div className="aspect-video w-full">
                    <img
                      src={project.image_path}
                      alt={project.name}
                      className="w-full h-full object-cover"
                    />
                  </div>
                )}
                {!project.image_path && (
                  <div className="aspect-video w-full bg-gradient-to-br from-emerald-500 to-blue-600 flex items-center justify-center">
                    <div className="text-white text-8xl font-bold opacity-20">
                      {project.name.charAt(0).toUpperCase()}
                    </div>
                  </div>
                )}
                <CardContent className="p-6">
                  <div className="space-y-4">
                    <div>
                      <div className="flex items-center space-x-2 mb-3">
                        <DocumentTextIcon className="w-5 h-5 text-gray-400" />
                        <h3 className="text-lg font-semibold text-gray-900">Description</h3>
                      </div>
                      <p className="text-gray-700 leading-relaxed">
                        {project.description || "No description provided for this project."}
                      </p>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Project Details Sidebar */}
            <div className="space-y-6">
              {/* Quick Stats */}
              <Card>
                <CardContent className="p-6">
                  <div className="flex items-center space-x-2 mb-4">
                    <ChartBarIcon className="w-5 h-5 text-gray-400" />
                    <h3 className="text-lg font-semibold text-gray-900">Project Details</h3>
                  </div>
                  <div className="space-y-4">
                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-2">
                        <CalendarIcon className="w-4 h-4 text-gray-400" />
                        <span className="text-sm font-medium text-gray-500">Due Date</span>
                      </div>
                      <span className="text-sm font-semibold text-gray-900">{project.due_date}</span>
                    </div>
                    
                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-2">
                        <ClockIcon className="w-4 h-4 text-gray-400" />
                        <span className="text-sm font-medium text-gray-500">Created</span>
                      </div>
                      <span className="text-sm font-semibold text-gray-900">{project.created_at}</span>
                    </div>

                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-2">
                        <UserIcon className="w-4 h-4 text-gray-400" />
                        <span className="text-sm font-medium text-gray-500">Created By</span>
                      </div>
                      <span className="text-sm font-semibold text-gray-900">{project.createdBy?.name}</span>
                    </div>

                    {project.updatedBy && (
                      <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                          <UserIcon className="w-4 h-4 text-gray-400" />
                          <span className="text-sm font-medium text-gray-500">Updated By</span>
                        </div>
                        <span className="text-sm font-semibold text-gray-900">{project.updatedBy?.name}</span>
                      </div>
                    )}
                  </div>
                </CardContent>
              </Card>

              {/* Quick Actions */}
              <Card>
                <CardContent className="p-6">
                  <h3 className="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                  <div className="space-y-3">
                    <Link
                      href={route("project.edit", project.id)}
                      className="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all"
                    >
                      <PencilIcon className="w-4 h-4 mr-2" />
                      Edit Project
                    </Link>
                    <Link
                      href={route("project.index")}
                      className="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-all"
                    >
                      ← Back to Projects
                    </Link>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>

          {/* Project Tasks */}
          <Card>
            <CardContent className="p-6">
              <div className="flex items-center justify-between mb-6">
                <div>
                  <h3 className="text-xl font-semibold text-gray-900">Project Tasks</h3>
                  <p className="text-sm text-gray-600 mt-1">
                    Manage and track tasks for this project
                  </p>
                </div>
                <div className="text-sm text-gray-500">
                  {tasks?.data?.length || 0} tasks
                </div>
              </div>
              
              {tasks?.data?.length > 0 ? (
                <TasksTable
                  tasks={tasks}
                  success={success}
                  queryParams={queryParams}
                  hideProjectColumn={true}
                />
              ) : (
                <div className="text-center py-12">
                  <div className="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <ChartBarIcon className="w-12 h-12 text-gray-400" />
                  </div>
                  <h3 className="text-lg font-medium text-gray-900 mb-2">No tasks yet</h3>
                  <p className="text-gray-500 mb-6">
                    Start organizing your project by adding some tasks.
                  </p>
                  <button className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                    Add First Task
                  </button>
                </div>
              )}
            </CardContent>
          </Card>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
