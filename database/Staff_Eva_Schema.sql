-- Grade Scales Table
CREATE TABLE grade_scales (
    grade_scale_id INT AUTO_INCREMENT PRIMARY KEY,
    min_percentage DECIMAL(5,2) NOT NULL,
    max_percentage DECIMAL(5,2) NOT NULL,
    grade CHAR(2) NOT NULL,
    meaning VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_grade_range (min_percentage, max_percentage)
);

-- Evaluation Types Table
CREATE TABLE evaluation_types (
    evaluation_type_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    weight DECIMAL(5,2) DEFAULT 100.0,
    order_number INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_evaluation_type_name (name)
);

-- Departments Table
CREATE TABLE departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    manager_id VARCHAR(10), -- Will be linked later
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_department_name (name),
    INDEX idx_department_status (status)
);

-- Positions Table
CREATE TABLE positions (
    position_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    level VARCHAR(50),
    description TEXT,
    department_id INT,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(department_id),
    UNIQUE INDEX idx_position_title_level_dept (title, level, department_id),
    INDEX idx_position_status (status)
);

-- Projects Table
CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    start_date DATE NOT NULL,
    end_date DATE,
    site_manager_id VARCHAR(10), -- Will be linked later
    status ENUM('planning', 'active', 'on-hold', 'completed', 'cancelled') NOT NULL DEFAULT 'planning',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_project_name (name),
    INDEX idx_project_status (status),
    INDEX idx_project_dates (start_date, end_date)
);

-- Users Table
CREATE TABLE users (
    employee_id VARCHAR(10) PRIMARY KEY,
    kh_name VARCHAR(255) NOT NULL,
    en_name VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    work_contract ENUM('Permanent', 'Project-based', 'Internship', 'Subcontract') NOT NULL,
    sex ENUM('Male', 'Female') NOT NULL,
    position_id INT,
    department_id INT,
    project_id INT,
    role ENUM('admin', 'GM', 'Manager', 'HR', 'Site Manager', 'Site Supervisor', 'Site Team Leader', 'Staff') NOT NULL,
    hire_date DATE NOT NULL,
    end_date DATE,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP,
    INDEX idx_employee_status (status),
    INDEX idx_employee_department (department_id),
    INDEX idx_employee_position (position_id),
    INDEX idx_employee_project (project_id)
);

-- Add deferred foreign key constraints for users
ALTER TABLE users
    ADD FOREIGN KEY (position_id) REFERENCES positions(position_id),
    ADD FOREIGN KEY (department_id) REFERENCES departments(department_id),
    ADD FOREIGN KEY (project_id) REFERENCES projects(project_id);

-- Add deferred foreign key for departments.manager_id
ALTER TABLE departments
    ADD FOREIGN KEY (manager_id) REFERENCES users(employee_id);

-- Add deferred foreign key for projects.site_manager_id
ALTER TABLE projects
    ADD FOREIGN KEY (site_manager_id) REFERENCES users(employee_id);

-- Evaluation Templates Table
CREATE TABLE evaluation_templates (
    evaluation_template_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    version VARCHAR(10) NOT NULL,
    revision INT NOT NULL DEFAULT 1,
    effective_date DATE NOT NULL,
    expiration_date DATE,
    position_id INT,
    department_id INT,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_by VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (position_id) REFERENCES positions(position_id),
    FOREIGN KEY (department_id) REFERENCES departments(department_id),
    FOREIGN KEY (created_by) REFERENCES users(employee_id),
    UNIQUE INDEX idx_template_name_version (name, version),
    INDEX idx_template_active (is_active)
);

-- Evaluation Criteria Categories Table
CREATE TABLE evaluation_criteria_categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    evaluation_template_id INT NOT NULL,
    weight DECIMAL(5,2) DEFAULT 100.0,
    order_number INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (evaluation_template_id) REFERENCES evaluation_templates(evaluation_template_id),
    UNIQUE INDEX idx_category_template_name (evaluation_template_id, name),
    INDEX idx_category_order (evaluation_template_id, order_number)
);

-- Evaluation Criteria Table
CREATE TABLE evaluation_criteria (
    criteria_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    weight DECIMAL(5,2) NOT NULL DEFAULT 1.0,
    min_score INT NOT NULL DEFAULT 1,
    max_score INT NOT NULL DEFAULT 5,
    order_number INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES evaluation_criteria_categories(category_id),
    UNIQUE INDEX idx_criteria_category_name (category_id, name),
    INDEX idx_criteria_order (category_id, order_number)
);

-- Evaluation Periods Table
CREATE TABLE evaluation_periods (
    period_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    submission_deadline DATE NOT NULL,
    status ENUM('upcoming', 'active', 'closed') NOT NULL DEFAULT 'upcoming',
    created_by VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(employee_id),
    UNIQUE INDEX idx_period_name (name),
    INDEX idx_period_dates (start_date, end_date),
    INDEX idx_period_status (status)
);

-- Evaluations Table
CREATE TABLE evaluations (
    evaluation_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(10) NOT NULL,
    evaluator_id VARCHAR(10) NOT NULL,
    template_id INT NOT NULL,
    period_id INT NOT NULL,
    evaluation_type_id INT NOT NULL,
    total_score DECIMAL(5,2),
    grade_id INT,
    status ENUM('NOT_STARTED', 'SELF_EVALUATION_PENDING', 'STAFF_EVALUATION_PENDING', 'FINAL_EVALUATION_PENDING', 'COMPLETED') NOT NULL DEFAULT 'NOT_STARTED',
    evaluation_date DATE,
    due_date DATE NOT NULL,
    submission_date TIMESTAMP,
    overall_comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES users(employee_id),
    FOREIGN KEY (evaluator_id) REFERENCES users(employee_id),
    FOREIGN KEY (template_id) REFERENCES evaluation_templates(evaluation_template_id),
    FOREIGN KEY (period_id) REFERENCES evaluation_periods(period_id),
    FOREIGN KEY (evaluation_type_id) REFERENCES evaluation_types(evaluation_type_id),
    FOREIGN KEY (grade_id) REFERENCES grade_scales(grade_scale_id),
    UNIQUE INDEX idx_evaluation_unique (employee_id, evaluator_id, template_id, period_id, evaluation_type_id),
    INDEX idx_evaluation_employee (employee_id),
    INDEX idx_evaluation_status (status),
    INDEX idx_evaluation_period (period_id),
    INDEX idx_evaluation_dates (due_date, submission_date)
);

-- Evaluation Responses Table
CREATE TABLE evaluation_responses (
    response_id INT AUTO_INCREMENT PRIMARY KEY,
    evaluation_id INT NOT NULL,
    criteria_id INT NOT NULL,
    score INT NOT NULL,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (evaluation_id) REFERENCES evaluations(evaluation_id),
    FOREIGN KEY (criteria_id) REFERENCES evaluation_criteria(criteria_id),
    UNIQUE INDEX idx_response_unique (evaluation_id, criteria_id),
    INDEX idx_response_score (score)
);

