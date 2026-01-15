Analyze this ContactService.php class and write a comprehensive Laravel Feature Test for it.

Requirements:

-   **Setup**:
    -   Use `RefreshDatabase`.
    -   Seed `UserSeeder` and `ContactSeeder` in `setUp()`.
-   **Roles**:
    -   **Admin**: Must see all 10 contacts.
    -   **User**: Must see only their 2 contacts.
-   **Storage**: Mock the `public` disk.
    -   **Update**: Verify the old photo is replaced.
    -   **Delete**: Verify the photo is removed from storage.
-   **Filtering**: Test `filterByCity` with: City ID, Search term, and both combined.
-   **Rules**:
    -   Do NOT test the create method.
    -   Use `test_` prefixes.
    -   Ensure clean code and standard assertions.
    