import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import { Card, CardContent } from "@/Components/Card";
import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import { useState } from "react";
import { 
  UserIcon,
  EnvelopeIcon,
  LockClosedIcon,
  ArrowLeftIcon,
  EyeIcon,
  EyeSlashIcon,
  PencilIcon,
  CheckCircleIcon,
  XCircleIcon,
  PhoneIcon,
  BuildingOfficeIcon,
  BriefcaseIcon,
  IdentificationIcon,
  DocumentTextIcon
} from "@heroicons/react/24/outline";

export default function Edit({ auth, user }) {
  const { data, setData, put, errors, processing } = useForm({
    name: user.name || "",
    email: user.email || "",
    password: "",
    password_confirmation: "",
    department: user.department || "",
    phone: user.phone || "",
    role: user.role || "user",
    position: user.position || "",
    work_contract: user.work_contract || "Permanent",
    gender: user.gender || "Male",
    project: user.project || "",
  });

  const [showPassword, setShowPassword] = useState(false);
  const [showPasswordConfirmation, setShowPasswordConfirmation] = useState(false);

  const onSubmit = (e) => {
    e.preventDefault();
    put(route("user.update", user.id));
  };

  const getPasswordStrength = (password) => {
    if (!password) return { strength: 0, checks: {} };
    
    let strength = 0;
    const checks = {
      length: password.length >= 8,
      letters: /[a-zA-Z]/.test(password),
      symbols: /[^a-zA-Z0-9]/.test(password),
      numbers: /\d/.test(password)
    };

    Object.values(checks).forEach(check => {
      if (check) strength++;
    });

    return { strength, checks };
  };

  const passwordAnalysis = getPasswordStrength(data.password);
  
  const getStrengthColor = (strength) => {
    if (strength === 0) return 'bg-gray-200';
    if (strength <= 2) return 'bg-red-400';
    if (strength === 3) return 'bg-yellow-400';
    return 'bg-green-400';
  };

  const getStrengthText = (strength) => {
    if (strength === 0) return 'Enter new password';
    if (strength <= 2) return 'Weak';
    if (strength === 3) return 'Good';
    return 'Strong';
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
              <h2 className="text-2xl font-bold text-gray-900">Edit User</h2>
              <p className="text-sm text-gray-600 mt-1">
                Update user information and settings
              </p>
            </div>
          </div>
          <div className="flex items-center space-x-2">
            <div className="flex items-center space-x-2 text-sm text-gray-500">
              <PencilIcon className="w-4 h-4" />
              <span>Editing {user.name}</span>
            </div>
          </div>
        </div>
      }
    >
      <Head title={`Edit User: ${user.name}`} />

      <div className="py-8">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <form onSubmit={onSubmit} className="space-y-6">
            {/* Current User Info */}
            <Card>
              <CardContent className="p-6">
                <div className="border-b border-gray-200 pb-4 mb-6">
                  <h3 className="text-lg font-semibold text-gray-900">Current User</h3>
                  <p className="text-sm text-gray-600">Information about the user being edited</p>
                </div>

                <div className="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                  <div className={`w-16 h-16 rounded-full flex items-center justify-center text-white font-semibold text-lg ${getAvatarColor(user.id)}`}>
                    {getUserInitials(user.name)}
                  </div>
                  <div>
                    <h4 className="text-lg font-medium text-gray-900">{user.name}</h4>
                    <p className="text-sm text-gray-600 flex items-center">
                      <EnvelopeIcon className="w-4 h-4 mr-1" />
                      {user.email}
                    </p>
                    <p className="text-xs text-gray-500 mt-1">User ID: #{user.id}</p>
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* User Information Section */}
            <Card>
              <CardContent className="p-6">
                <div className="border-b border-gray-200 pb-4 mb-6">
                  <div className="flex items-center space-x-3">
                    <div className="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                      <UserIcon className="w-5 h-5 text-emerald-600" />
                    </div>
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900">User Information</h3>
                      <p className="text-sm text-gray-600">Update basic user information</p>
                    </div>
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  {/* Full Name */}
                  <div>
                    <InputLabel 
                      htmlFor="user_name" 
                      value="Full Name" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <UserIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_name"
                        type="text"
                        name="name"
                        value={data.name}
                        className="pl-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter user's full name"
                        onChange={(e) => setData("name", e.target.value)}
                        required
                      />
                    </div>
                    <InputError message={errors.name} className="mt-2" />
                  </div>

                  {/* Email */}
                  <div>
                    <InputLabel 
                      htmlFor="user_email" 
                      value="Email Address" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <EnvelopeIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="pl-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter email address"
                        onChange={(e) => setData("email", e.target.value)}
                        required
                      />
                    </div>
                    <InputError message={errors.email} className="mt-2" />
                  </div>

                  {/* Phone */}
                  <div>
                    <InputLabel 
                      htmlFor="user_phone" 
                      value="Phone Number" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <PhoneIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_phone"
                        type="text"
                        name="phone"
                        value={data.phone}
                        className="pl-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter phone number"
                        onChange={(e) => setData("phone", e.target.value)}
                      />
                    </div>
                    <InputError message={errors.phone} className="mt-2" />
                  </div>

                  {/* Gender */}
                  <div>
                    <InputLabel 
                      htmlFor="user_gender" 
                      value="Gender" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <SelectInput
                      id="user_gender"
                      name="gender"
                      value={data.gender}
                      className="mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                      onChange={(e) => setData("gender", e.target.value)}
                    >
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </SelectInput>
                    <InputError message={errors.gender} className="mt-2" />
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Work Information Section */}
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
                  {/* Department */}
                  <div>
                    <InputLabel 
                      htmlFor="user_department" 
                      value="Department" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <BuildingOfficeIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_department"
                        type="text"
                        name="department"
                        value={data.department}
                        className="pl-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter department"
                        onChange={(e) => setData("department", e.target.value)}
                      />
                    </div>
                    <InputError message={errors.department} className="mt-2" />
                  </div>

                  {/* Position */}
                  <div>
                    <InputLabel 
                      htmlFor="user_position" 
                      value="Position" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <BriefcaseIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_position"
                        type="text"
                        name="position"
                        value={data.position}
                        className="pl-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter position/job title"
                        onChange={(e) => setData("position", e.target.value)}
                      />
                    </div>
                    <InputError message={errors.position} className="mt-2" />
                  </div>

                  {/* Role */}
                  <div>
                    <InputLabel 
                      htmlFor="user_role" 
                      value="System Role" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <IdentificationIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_role"
                        type="text"
                        name="role"
                        value={data.role}
                        className="pl-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter system role"
                        onChange={(e) => setData("role", e.target.value)}
                      />
                    </div>
                    <InputError message={errors.role} className="mt-2" />
                  </div>

                  {/* Work Contract */}
                  <div>
                    <InputLabel 
                      htmlFor="user_work_contract" 
                      value="Work Contract" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <SelectInput
                      id="user_work_contract"
                      name="work_contract"
                      value={data.work_contract}
                      className="mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                      onChange={(e) => setData("work_contract", e.target.value)}
                    >
                      <option value="Permanent">Permanent</option>
                      <option value="Project-based">Project-based</option>
                      <option value="Internship">Internship</option>
                      <option value="Subcontract">Subcontract</option>
                    </SelectInput>
                    <InputError message={errors.work_contract} className="mt-2" />
                  </div>

                  {/* Project */}
                  <div className="md:col-span-2">
                    <InputLabel 
                      htmlFor="user_project" 
                      value="Project Assignment" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <DocumentTextIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_project"
                        type="text"
                        name="project"
                        value={data.project}
                        className="pl-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter assigned project"
                        onChange={(e) => setData("project", e.target.value)}
                      />
                    </div>
                    <InputError message={errors.project} className="mt-2" />
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Password Section */}
            <Card>
              <CardContent className="p-6">
                <div className="border-b border-gray-200 pb-4 mb-6">
                  <div className="flex items-center space-x-3">
                    <div className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                      <LockClosedIcon className="w-5 h-5 text-blue-600" />
                    </div>
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900">Change Password</h3>
                      <p className="text-sm text-gray-600">Leave blank to keep current password</p>
                    </div>
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  {/* New Password */}
                  <div>
                    <InputLabel 
                      htmlFor="user_password" 
                      value="New Password" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <LockClosedIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_password"
                        type={showPassword ? "text" : "password"}
                        name="password"
                        value={data.password}
                        className="pl-10 pr-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Enter new password (optional)"
                        onChange={(e) => setData("password", e.target.value)}
                      />
                      <button
                        type="button"
                        className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        onClick={() => setShowPassword(!showPassword)}
                      >
                        {showPassword ? <EyeSlashIcon className="w-5 h-5" /> : <EyeIcon className="w-5 h-5" />}
                      </button>
                    </div>
                    <InputError message={errors.password} className="mt-2" />
                    
                    {/* Password Strength Indicator */}
                    {data.password && (
                      <div className="mt-3">
                        <div className="flex items-center justify-between mb-2">
                          <span className="text-xs text-gray-600">Password strength:</span>
                          <span className={`text-xs font-medium ${
                            passwordAnalysis.strength <= 2 ? 'text-red-600' : 
                            passwordAnalysis.strength === 3 ? 'text-yellow-600' : 'text-green-600'
                          }`}>
                            {getStrengthText(passwordAnalysis.strength)}
                          </span>
                        </div>
                        <div className="w-full bg-gray-200 rounded-full h-2 mb-3">
                          <div 
                            className={`h-2 rounded-full transition-all duration-300 ${getStrengthColor(passwordAnalysis.strength)}`}
                            style={{ width: `${(passwordAnalysis.strength / 4) * 100}%` }}
                          ></div>
                        </div>
                        <div className="grid grid-cols-2 gap-2 text-xs">
                          <div className={`flex items-center space-x-1 ${passwordAnalysis.checks.length ? 'text-green-600' : 'text-gray-400'}`}>
                            {passwordAnalysis.checks.length ? <CheckCircleIcon className="w-3 h-3" /> : <XCircleIcon className="w-3 h-3" />}
                            <span>8+ characters</span>
                          </div>
                          <div className={`flex items-center space-x-1 ${passwordAnalysis.checks.letters ? 'text-green-600' : 'text-gray-400'}`}>
                            {passwordAnalysis.checks.letters ? <CheckCircleIcon className="w-3 h-3" /> : <XCircleIcon className="w-3 h-3" />}
                            <span>Letters</span>
                          </div>
                          <div className={`flex items-center space-x-1 ${passwordAnalysis.checks.symbols ? 'text-green-600' : 'text-gray-400'}`}>
                            {passwordAnalysis.checks.symbols ? <CheckCircleIcon className="w-3 h-3" /> : <XCircleIcon className="w-3 h-3" />}
                            <span>Symbols</span>
                          </div>
                          <div className={`flex items-center space-x-1 ${passwordAnalysis.checks.numbers ? 'text-green-600' : 'text-gray-400'}`}>
                            {passwordAnalysis.checks.numbers ? <CheckCircleIcon className="w-3 h-3" /> : <XCircleIcon className="w-3 h-3" />}
                            <span>Numbers</span>
                          </div>
                        </div>
                      </div>
                    )}
                  </div>

                  {/* Confirm Password */}
                  <div>
                    <InputLabel 
                      htmlFor="user_password_confirmation" 
                      value="Confirm New Password" 
                      className="text-sm font-medium text-gray-700 mb-2" 
                    />
                    <div className="relative">
                      <LockClosedIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
                      <TextInput
                        id="user_password_confirmation"
                        type={showPasswordConfirmation ? "text" : "password"}
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="pl-10 pr-10 mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        placeholder="Confirm new password"
                        onChange={(e) => setData("password_confirmation", e.target.value)}
                      />
                      <button
                        type="button"
                        className="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        onClick={() => setShowPasswordConfirmation(!showPasswordConfirmation)}
                      >
                        {showPasswordConfirmation ? <EyeSlashIcon className="w-5 h-5" /> : <EyeIcon className="w-5 h-5" />}
                      </button>
                    </div>
                    <InputError message={errors.password_confirmation} className="mt-2" />
                    
                    {/* Password Match Indicator */}
                    {data.password && data.password_confirmation && (
                      <div className="mt-2">
                        {data.password === data.password_confirmation ? (
                          <div className="flex items-center space-x-1 text-green-600 text-xs">
                            <CheckCircleIcon className="w-3 h-3" />
                            <span>Passwords match</span>
                          </div>
                        ) : (
                          <div className="flex items-center space-x-1 text-red-600 text-xs">
                            <XCircleIcon className="w-3 h-3" />
                            <span>Passwords don't match</span>
                          </div>
                        )}
                      </div>
                    )}
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Form Actions */}
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
              <div className="text-sm text-gray-500">
                <span className="font-medium">Note:</span> Changes will be saved immediately upon submission.
              </div>
              
              <div className="flex items-center space-x-3">
                <SecondaryButton asChild>
                  <Link href={route("users.index")}>
                    Cancel
                  </Link>
                </SecondaryButton>
                
                <PrimaryButton 
                  type="submit" 
                  disabled={processing}
                  className="bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500"
                >
                  {processing ? (
                    <div className="flex items-center space-x-2">
                      <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                      <span>Updating...</span>
                    </div>
                  ) : (
                    <div className="flex items-center space-x-2">
                      <PencilIcon className="w-4 h-4" />
                      <span>Update User</span>
                    </div>
                  )}
                </PrimaryButton>
              </div>
            </div>
          </form>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
