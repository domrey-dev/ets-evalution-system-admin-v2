import Pagination from "@/Components/Pagination";
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import { Card, CardContent } from "@/Components/Card";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import PrimaryButton from "@/Components/PrimaryButton";
import { Head, Link, router } from "@inertiajs/react";
import { useState } from "react";
import { 
  UserIcon,
  MagnifyingGlassIcon,
  PlusIcon,
  PhoneIcon,
  PencilIcon,
  TrashIcon
} from "@heroicons/react/24/outline";

export default function Index({ auth, users, queryParams = null, success, roles = [] }) {
  queryParams = queryParams || {};
  
  const [filters, setFilters] = useState({
    name: queryParams.name || "",
    phone: queryParams.phone || "",
    role: queryParams.role || "",
    work_contract: queryParams.work_contract || "",
    gender: queryParams.gender || ""
  });

  const clearFilters = () => {
    const clearedFilters = {
      name: '',
      phone: '',
      role: '',
      work_contract: '',
      gender: ''
    };
    setFilters(clearedFilters);
    
    // Automatically apply cleared filters
    router.get(route("users.index"), {}, {
      preserveState: true,
      replace: true,
    });
  };

  const applyFilters = () => {
    // Remove empty filters
    const filterData = {};
    Object.keys(filters).forEach(key => {
      if (filters[key]) {
        filterData[key] = filters[key];
      }
    });

    router.get(route("users.index"), filterData, {
      preserveState: true,
      replace: true,
    });
  };

  const handleKeyPress = (e) => {
    if (e.key === 'Enter') {
      applyFilters();
    }
  };

  const deleteUser = (user) => {
    if (!window.confirm(`Are you sure you want to delete "${user.name}"?`)) {
      return;
    }
    router.delete(route("user.destroy", user.id));
  };

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
          <div>
            <h2 className="text-2xl font-bold text-gray-900">Users</h2>
            <p className="text-sm text-gray-600 mt-1">
              Manage system users and their permissions
            </p>
          </div>
          <Link
            href={route("user.create")}
            className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200"
          >
            <PlusIcon className="w-4 h-4 mr-2" />
            Add New User
          </Link>
        </div>
      }
    >
      <Head title="Users" />

      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Success Message */}
          {success && (
            <div className="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg">
              {success}
            </div>
          )}

          {/* Search and Filters */}
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <div className="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                {/* <h3 className="text-lg font-semibold text-gray-900 mb-4">Filter Users</h3> */}
                <div className="flex flex-col lg:flex-row lg:items-end gap-4">
                  <div className="flex-1">
                    <div className="space-y-4">
                      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <div className="min-w-0">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Name
                          </label>
                          <TextInput
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            defaultValue={queryParams?.name}
                            placeholder="Search by name..."
                            value={filters.name}
                            onChange={(e) => setFilters({...filters, name: e.target.value})}
                            onKeyPress={handleKeyPress}
                          />
                        </div>
                        <div className="min-w-0">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Phone
                          </label>
                          <TextInput
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            defaultValue={queryParams?.phone}
                            placeholder="Search by phone..."
                            value={filters.phone}
                            onChange={(e) => setFilters({...filters, phone: e.target.value})}
                            onKeyPress={handleKeyPress}
                          />
                        </div>
                        <div className="min-w-0 sm:col-span-2 lg:col-span-1">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Role
                          </label>
                          <TextInput
                            list="roles"
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            defaultValue={queryParams?.role}
                            placeholder="Type or select role..."
                            value={filters.role}
                            onChange={(e) => setFilters({...filters, role: e.target.value})}
                            onKeyPress={handleKeyPress}
                          />
                          <datalist id="roles">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                            <option value="staff">Staff</option>
                            <option value="manager">Manager</option>
                          </datalist>
                        </div>
                      </div>
                      <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div className="min-w-0">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Work Contract
                          </label>
                          <SelectInput
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            value={filters.work_contract}
                            onChange={(e) => setFilters({...filters, work_contract: e.target.value})}
                            onKeyPress={handleKeyPress}
                          >
                            <option value="">All Contracts</option>
                            <option value="full-time">Full Time</option>
                            <option value="part-time">Part Time</option>
                            <option value="contract">Contract</option>
                          </SelectInput>
                        </div>
                        <div className="min-w-0">
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Gender
                          </label>
                          <SelectInput
                            className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            value={filters.gender}
                            onChange={(e) => setFilters({...filters, gender: e.target.value})}
                            onKeyPress={handleKeyPress}
                          >
                            <option value="">All Genders</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                          </SelectInput>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div className="hidden lg:block w-px h-32 bg-gray-300 mx-4"></div>
                  
                  <div className="flex flex-row gap-3 lg:flex-shrink-0 lg:self-center">
                    <PrimaryButton
                      className="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                      onClick={clearFilters}
                    >
                      Clear
                    </PrimaryButton>
                    <PrimaryButton
                      className="px-4 lg:px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                      onClick={applyFilters}
                    >
                      Apply
                    </PrimaryButton>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Content - Table Only */}
          {users && users.data && users.data.length > 0 ? (
            <Card>
              <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-200">
                  <thead className="bg-gray-50">
                    <tr>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 sm:w-16">
                        ID
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Phone
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Contract
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-24">
                        Gender
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Position
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Department
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Project
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-32">
                        Role
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-16 sm:w-32">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody className="bg-white divide-y divide-gray-200">
                    {users.data.map((user) => (
                      <tr key={user.id} className="hover:bg-gray-50">
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                          {user.id}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4">
                          <div className="flex items-center">
                            <div className="flex-shrink-0 h-6 w-6 sm:h-8 sm:w-8">
                              <div className={`w-6 h-6 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-white font-semibold text-xs ${getAvatarColor(user.id)}`}>
                                {getUserInitials(user.name)}
                              </div>
                            </div>
                            <div className="ml-2 sm:ml-3 min-w-0 flex-1">
                              <div className="text-xs sm:text-sm font-medium text-gray-900 truncate">
                                {user.name}
                              </div>
                              <div className="text-xs text-gray-500 truncate">
                                {user.email}
                              </div>
                            </div>
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          {user.phone || '-'}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap">
                          {user.work_contract && (
                            <span className={`px-1 sm:px-2 py-1 rounded-full text-xs font-medium ${getContractColor(user.work_contract)}`}>
                              <span className="hidden sm:inline">{user.work_contract}</span>
                              <span className="sm:hidden">{user.work_contract?.substring(0, 8)}</span>
                            </span>
                          )}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          {user.gender || '-'}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          <div className="truncate max-w-24 sm:max-w-32">
                            {user.position || '-'}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          <div className="truncate max-w-24 sm:max-w-32">
                            {user.department || '-'}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          <div className="truncate max-w-24 sm:max-w-32">
                            {user.project || '-'}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          <div className="truncate max-w-16 sm:max-w-32">
                            {user.role || '-'}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                          <div className="flex items-center justify-end space-x-1 sm:space-x-2">
                            <Link
                              href={route("user.edit", user.id)}
                              className="text-emerald-600 hover:text-emerald-900 transition-colors"
                              title="Edit"
                            >
                              <PencilIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </Link>
                            <button
                              onClick={() => deleteUser(user)}
                              className="text-red-600 hover:text-red-900 transition-colors"
                              title="Delete"
                            >
                              <TrashIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
              <div className="px-4 py-4 border-t border-gray-200">
                <Pagination links={users.meta.links} />
              </div>
            </Card>
          ) : (
            /* Empty State */
            <Card className="text-center py-12">
              <CardContent>
                <div className="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                  <UserIcon className="w-12 h-12 text-gray-400" />
                </div>
                <h3 className="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                <p className="text-gray-500 mb-6">
                  {filters.name || filters.phone || filters.role
                    ? "No users match your search criteria. Try adjusting your filters."
                    : "Get started by creating your first user."
                  }
                </p>
                {!filters.name && !filters.phone && !filters.role && (
                  <Link
                    href={route("user.create")}
                    className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all"
                  >
                    <PlusIcon className="w-4 h-4 mr-2" />
                    Create User
                  </Link>
                )}
              </CardContent>
            </Card>
          )}
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
