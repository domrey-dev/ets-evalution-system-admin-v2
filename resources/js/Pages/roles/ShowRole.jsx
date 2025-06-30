import { Link, usePage } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function ShowRole({ auth }) {
    const { role } = usePage().props;
    const { can } = auth;

    return (
        <AuthenticatedLayout
            auth={auth}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Role Details
                </h2>
            }
        >
            <Head title={`Role - ${role.name}`} />

            <div className="py-12">
                <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
                    <div className="bg-white shadow rounded-lg overflow-hidden">
                        {/* Header */}
                        <div className="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <h1 className="text-2xl font-semibold text-gray-800">
                                {role.name}
                            </h1>
                            <div className="flex space-x-2">
                                <Link
                                    href={route("roles.index")}
                                    className="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    Back to Roles
                                </Link>
                            </div>
                        </div>

                        <div className="p-6">
                            {/* Role Details */}
                            <div className="mb-8">
                                <h2 className="text-lg font-medium text-gray-700 mb-2">Role Information</h2>
                                <div className="bg-gray-50 p-4 rounded-md">
                                    <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <p className="text-sm font-medium text-gray-500">Role ID</p>
                                            <p className="mt-1 text-sm text-gray-900">{role.id}</p>
                                        </div>
                                        <div>
                                            <p className="text-sm font-medium text-gray-500">Role Name</p>
                                            <p className="mt-1 text-sm text-gray-900">{role.name}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Permissions */}
                            <div>
                                <h2 className="text-lg font-medium text-gray-700 mb-2">Assigned Permissions</h2>
                                {role.permissions.length > 0 ? (
                                    <div className="bg-gray-50 p-4 rounded-md">
                                        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                            {role.permissions.map((permission) => (
                                                <div
                                                    key={permission}
                                                    className="bg-white p-3 rounded-md shadow-sm border border-gray-200"
                                                >
                                                    <span className="text-sm font-medium text-gray-900">{permission}</span>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                ) : (
                                    <div className="bg-gray-50 p-4 rounded-md text-center">
                                        <p className="text-gray-500">No permissions assigned to this role.</p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
