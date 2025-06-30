import { Card, CardContent } from "@/Components/Card";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { 
  UserIcon,
  EnvelopeIcon,
  CalendarIcon,
  PencilIcon,
  ArrowLeftIcon,
  IdentificationIcon,
  PhoneIcon,
  BuildingOfficeIcon,
  BriefcaseIcon,
  DocumentTextIcon,
  CheckBadgeIcon
} from "@heroicons/react/24/outline";

export default function Show({ auth, user }) {
  const getUserInitials = (name) => {
    return name
      .split(' ')
      .map(word => word.charAt(0))
      .join('')
      .toUpperCase()
      .slice(0, 2);
  };

  const getAvatarColor = (id) => {
    const colors = [
      'bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500',
      'bg-indigo-500', 'bg-yellow-500', 'bg-red-500', 'bg-gray-500'
    ];
    return colors[id % colors.length];
  };

  const getContractColor = (contract) => {
    const colors = {
      'Permanent': 'bg-green-100 text-green-800',
      'Project-based': 'bg-blue-100 text-blue-800',
      'Internship': 'bg-yellow-100 text-yellow-800',
      'Subcontract': 'bg-purple-100 text-purple-800'
    };
    return colors[contract] || 'bg-gray-100 text-gray-800';
  };

  return (
    <AuthenticatedLayout
      auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div className="flex items-center space-x-4">
            <Link
              href={route("users.index")}
              className="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all"
            >
              <ArrowLeftIcon className="w-5 h-5" />
            </Link>
            <div>
              <h2 className="text-2xl font-bold text-gray-900">User Profile</h2>
              <p className="text-sm text-gray-600 mt-1">
                View user details and information
              </p>
            </div>
          </div>
          <div className="flex items-center space-x-3">
            <Link
              href={route("user.edit", user.id)}
              className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200"
            >
              <PencilIcon className="w-4 h-4 mr-2" />
              Edit User
            </Link>
          </div>
        </div>
      }
    >
      <Head title={`User - ${user.name}`} />

      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {/* User Profile Card */}
            <div className="lg:col-span-1">
              <Card className="sticky top-8">
                <CardContent className="p-6">
                  <div className="text-center">
                    {/* Avatar */}
                    <div className="mx-auto mb-4">
                      <div className={`w-24 h-24 rounded-full flex items-center justify-center text-white font-bold text-2xl ${getAvatarColor(user.id)}`}>
                        {getUserInitials(user.name)}
                      </div>
                    </div>

                    {/* User Name and Status */}
                    <h3 className="text-xl font-bold text-gray-900 mb-2">{user.name}</h3>
                    <div className="flex items-center justify-center space-x-2 mb-4">
                      <CheckBadgeIcon className="w-5 h-5 text-green-500" />
                      <span className="text-sm font-medium text-green-700">Active User</span>
                    </div>

                    {/* Contact Information */}
                    <div className="space-y-3 mb-6">
                      <div className="flex items-center justify-center space-x-2 text-gray-600">
                        <EnvelopeIcon className="w-4 h-4" />
                        <span className="text-sm">{user.email}</span>
                      </div>
                      {user.phone && (
                        <div className="flex items-center justify-center space-x-2 text-gray-600">
                          <PhoneIcon className="w-4 h-4" />
                          <span className="text-sm">{user.phone}</span>
                        </div>
                      )}
                    </div>

                    {/* Contract Status */}
                    {user.work_contract && (
                      <div className="mb-6">
                        <span className={`px-3 py-1 rounded-full text-sm font-medium ${getContractColor(user.work_contract)}`}>
                          {user.work_contract}
                        </span>
                      </div>
                    )}

                    {/* User ID and Join Date */}
                    <div className="pt-4 border-t border-gray-200 space-y-2">
                      <div className="flex items-center justify-between text-sm">
                        <span className="text-gray-500">User ID:</span>
                        <span className="font-medium text-gray-900">#{user.id}</span>
                      </div>
                      <div className="flex items-center justify-between text-sm">
                        <span className="text-gray-500">Joined:</span>
                        <span className="font-medium text-gray-900">{user.created_at}</span>
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* User Details */}
            <div className="lg:col-span-2 space-y-6">
              {/* Personal Information */}
              <Card>
                <CardContent className="p-6">
                  <div className="border-b border-gray-200 pb-4 mb-6">
                    <div className="flex items-center space-x-3">
                      <div className="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <UserIcon className="w-5 h-5 text-emerald-600" />
                      </div>
                      <div>
                        <h3 className="text-lg font-semibold text-gray-900">Personal Information</h3>
                        <p className="text-sm text-gray-600">Basic user details and contact information</p>
                      </div>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label className="text-sm font-medium text-gray-500 uppercase tracking-wide">Full Name</label>
                      <p className="mt-1 text-lg font-medium text-gray-900">{user.name}</p>
                    </div>
                    <div>
                      <label className="text-sm font-medium text-gray-500 uppercase tracking-wide">Email Address</label>
                      <p className="mt-1 text-lg font-medium text-gray-900">{user.email}</p>
                    </div>
                    {user.phone && (
                      <div>
                        <label className="text-sm font-medium text-gray-500 uppercase tracking-wide">Phone Number</label>
                        <p className="mt-1 text-lg font-medium text-gray-900">{user.phone}</p>
                      </div>
                    )}
                    {user.gender && (
                      <div>
                        <label className="text-sm font-medium text-gray-500 uppercase tracking-wide">Gender</label>
                        <p className="mt-1 text-lg font-medium text-gray-900">{user.gender}</p>
                      </div>
                    )}
                  </div>
                </CardContent>
              </Card>

              {/* Work Information */}
              <Card>
                <CardContent className="p-6">
                  <div className="border-b border-gray-200 pb-4 mb-6">
                    <div className="flex items-center space-x-3">
                      <div className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <BriefcaseIcon className="w-5 h-5 text-blue-600" />
                      </div>
                      <div>
                        <h3 className="text-lg font-semibold text-gray-900">Work Information</h3>
                        <p className="text-sm text-gray-600">Professional details and work assignment</p>
                      </div>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {user.department && (
                      <div>
                        <label className="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                          <BuildingOfficeIcon className="w-4 h-4" />
                          <span>Department</span>
                        </label>
                        <p className="mt-1 text-lg font-medium text-gray-900">{user.department}</p>
                      </div>
                    )}
                    {user.position && (
                      <div>
                        <label className="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                          <BriefcaseIcon className="w-4 h-4" />
                          <span>Position</span>
                        </label>
                        <p className="mt-1 text-lg font-medium text-gray-900">{user.position}</p>
                      </div>
                    )}
                    {user.role && (
                      <div>
                        <label className="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                          <IdentificationIcon className="w-4 h-4" />
                          <span>System Role</span>
                        </label>
                        <p className="mt-1 text-lg font-medium text-gray-900">{user.role}</p>
                      </div>
                    )}
                    {user.work_contract && (
                      <div>
                        <label className="text-sm font-medium text-gray-500 uppercase tracking-wide">Work Contract</label>
                        <div className="mt-1">
                          <span className={`px-3 py-1 rounded-full text-sm font-medium ${getContractColor(user.work_contract)}`}>
                            {user.work_contract}
                          </span>
                        </div>
                      </div>
                    )}
                    {user.project && (
                      <div className="md:col-span-2">
                        <label className="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                          <DocumentTextIcon className="w-4 h-4" />
                          <span>Project Assignment</span>
                        </label>
                        <p className="mt-1 text-lg font-medium text-gray-900">{user.project}</p>
                      </div>
                    )}
                  </div>

                  {/* Empty State for Work Information */}
                  {!user.department && !user.position && !user.role && !user.project && (
                    <div className="text-center py-8">
                      <BriefcaseIcon className="mx-auto h-12 w-12 text-gray-400" />
                      <h3 className="mt-2 text-sm font-medium text-gray-900">No work information</h3>
                      <p className="mt-1 text-sm text-gray-500">Work details have not been assigned yet.</p>
                    </div>
                  )}
                </CardContent>
              </Card>

              {/* Account Information */}
              <Card>
                <CardContent className="p-6">
                  <div className="border-b border-gray-200 pb-4 mb-6">
                    <div className="flex items-center space-x-3">
                      <div className="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <IdentificationIcon className="w-5 h-5 text-purple-600" />
                      </div>
                      <div>
                        <h3 className="text-lg font-semibold text-gray-900">Account Information</h3>
                        <p className="text-sm text-gray-600">System access and account details</p>
                      </div>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label className="text-sm font-medium text-gray-500 uppercase tracking-wide">Account Status</label>
                      <div className="mt-1 flex items-center space-x-2">
                        <CheckBadgeIcon className="w-5 h-5 text-green-500" />
                        <span className="text-lg font-medium text-green-700">Active</span>
                      </div>
                    </div>
                    <div>
                      <label className="text-sm font-medium text-gray-500 uppercase tracking-wide">User ID</label>
                      <p className="mt-1 text-lg font-medium text-gray-900">#{user.id}</p>
                    </div>
                    <div>
                      <label className="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                        <CalendarIcon className="w-4 h-4" />
                        <span>Account Created</span>
                      </label>
                      <p className="mt-1 text-lg font-medium text-gray-900">{user.created_at}</p>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Quick Actions */}
              <Card>
                <CardContent className="p-6">
                  <div className="border-b border-gray-200 pb-4 mb-6">
                    <h3 className="text-lg font-semibold text-gray-900">Quick Actions</h3>
                    <p className="text-sm text-gray-600">Common actions for this user</p>
                  </div>

                  <div className="flex flex-wrap gap-3">
                    <Link
                      href={route("user.edit", user.id)}
                      className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all"
                    >
                      <PencilIcon className="w-4 h-4 mr-2" />
                      Edit Profile
                    </Link>
                    <Link
                      href={route("users.index")}
                      className="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all"
                    >
                      <UserIcon className="w-4 h-4 mr-2" />
                      View All Users
                    </Link>
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
