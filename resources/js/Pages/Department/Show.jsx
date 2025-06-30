import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { Card, CardContent } from "@/Components/Card";
import { 
  BuildingOfficeIcon,
  UserGroupIcon,
  ClockIcon,
  DocumentTextIcon,
  PencilIcon,
  UserIcon,
  CalendarIcon
} from "@heroicons/react/24/outline";

export default function Show({ auth, department }) {
  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div className="flex items-center space-x-4">
            <div className="flex-shrink-0">
              <div className="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <BuildingOfficeIcon className="w-6 h-6 text-emerald-600" />
              </div>
            </div>
            <div>
              <h2 className="text-2xl font-bold text-gray-900">{department.name}</h2>
              <p className="text-sm text-gray-500 mt-1">
                Department #{department.id}
              </p>
            </div>
          </div>
          <Link
            href={route("department.edit", department.id)}
            className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200"
          >
            <PencilIcon className="w-4 h-4 mr-2" />
            Edit Department
          </Link>
        </div>
      }
    >
      <Head title={`Department "${department.name}"`} />
      
      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
          {/* Department Overview */}
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {/* Department Details */}
            <div className="lg:col-span-2">
              <Card>
                <CardContent className="p-6">
                  <div className="space-y-6">
                    {/* Department Header */}
                    <div className="flex items-center space-x-3 pb-4 border-b border-gray-200">
                      <div className="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <BuildingOfficeIcon className="w-8 h-8 text-emerald-600" />
                      </div>
                      <div>
                        <h3 className="text-2xl font-bold text-gray-900">{department.name}</h3>
                        <p className="text-gray-500">Organizational Department</p>
                      </div>
                    </div>

                    {/* Department Description */}
                    <div>
                      <div className="flex items-center space-x-2 mb-3">
                        <DocumentTextIcon className="w-5 h-5 text-gray-400" />
                        <h4 className="text-lg font-semibold text-gray-900">Description</h4>
                      </div>
                      <p className="text-gray-700 leading-relaxed">
                        {department.description || "No description provided for this department."}
                      </p>
                    </div>

                    {/* Department Statistics */}
                    <div>
                      <h4 className="text-lg font-semibold text-gray-900 mb-4">Department Statistics</h4>
                      <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div className="bg-blue-50 rounded-lg p-4">
                          <div className="flex items-center">
                            <UserGroupIcon className="w-8 h-8 text-blue-600" />
                            <div className="ml-4">
                              <p className="text-sm font-medium text-blue-600">Staff Members</p>
                              <p className="text-2xl font-bold text-blue-900">0</p>
                            </div>
                          </div>
                        </div>
                        
                        <div className="bg-green-50 rounded-lg p-4">
                          <div className="flex items-center">
                            <ClockIcon className="w-8 h-8 text-green-600" />
                            <div className="ml-4">
                              <p className="text-sm font-medium text-green-600">Active Projects</p>
                              <p className="text-2xl font-bold text-green-900">0</p>
                            </div>
                          </div>
                        </div>
                        
                        <div className="bg-purple-50 rounded-lg p-4">
                          <div className="flex items-center">
                            <BuildingOfficeIcon className="w-8 h-8 text-purple-600" />
                            <div className="ml-4">
                              <p className="text-sm font-medium text-purple-600">Status</p>
                              <p className="text-lg font-bold text-purple-900">Active</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Department Details Sidebar */}
            <div className="space-y-6">
              {/* Department Info */}
              <Card>
                <CardContent className="p-6">
                  <h3 className="text-lg font-semibold text-gray-900 mb-4">Department Information</h3>
                  <div className="space-y-4">
                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-2">
                        <UserIcon className="w-4 h-4 text-gray-400" />
                        <span className="text-sm font-medium text-gray-500">Created By</span>
                      </div>
                      <span className="text-sm font-semibold text-gray-900">
                        {department.createdBy?.name || 'Unknown'}
                      </span>
                    </div>

                    <div className="flex items-center justify-between">
                      <div className="flex items-center space-x-2">
                        <CalendarIcon className="w-4 h-4 text-gray-400" />
                        <span className="text-sm font-medium text-gray-500">Created Date</span>
                      </div>
                      <span className="text-sm font-semibold text-gray-900">
                        {department.created_at || 'Unknown'}
                      </span>
                    </div>

                    {department.updatedBy && (
                      <div className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                          <UserIcon className="w-4 h-4 text-gray-400" />
                          <span className="text-sm font-medium text-gray-500">Updated By</span>
                        </div>
                        <span className="text-sm font-semibold text-gray-900">
                          {department.updatedBy.name}
                        </span>
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
                      href={route("department.edit", department.id)}
                      className="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all"
                    >
                      <PencilIcon className="w-4 h-4 mr-2" />
                      Edit Department
                    </Link>
                    <Link
                      href={route("department.index")}
                      className="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-all"
                    >
                      ← Back to Departments
                    </Link>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>

          {/* Department Staff */}
          <Card>
            <CardContent className="p-6">
              <div className="flex items-center justify-between mb-6">
                <div>
                  <h3 className="text-xl font-semibold text-gray-900">Department Staff</h3>
                  <p className="text-sm text-gray-600 mt-1">
                    Manage staff members in this department
                  </p>
                </div>
                <div className="text-sm text-gray-500">
                  0 staff members
                </div>
              </div>
              
              {/* Empty State for Staff */}
              <div className="text-center py-12">
                <div className="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                  <UserGroupIcon className="w-12 h-12 text-gray-400" />
                </div>
                <h3 className="text-lg font-medium text-gray-900 mb-2">No staff members yet</h3>
                <p className="text-gray-500 mb-6">
                  Start building your team by adding staff members to this department.
                </p>
                <button className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                  Add Staff Member
                </button>
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
